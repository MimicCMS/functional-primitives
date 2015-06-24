<?php
/**
 * @package Mimic\Functional
 * @since 0.1.0
 * @license MIT
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

use Closure;

/**
 * Memorize cache stores the results of invocation of callback arguments.
 *
 * This object is not meant to be used outside of the
 * {@link \Mimic\Functional\memorize()} function.
 *
 * @todo
 * This is probably a monad and might need to be transitioned over when monads
 * are added. Well, technically it is a functor.
 *
 * @since 0.1.0
 */
final class MemoizeCache {
	/**
	 * When there are no arguments to be passed.
	 *
	 * @since 0.1.0
	 */
	const NO_ARGS_KEY = '__empty__';

	/**
	 * Store the cached values.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	private $_storage = array();

	/**
	 * Stores the callback to delegate to.
	 *
	 * @var Closure
	 * @since 0.1.0
	 */
	private $_callback = null;

	/**
	 *
	 * @param Closure $callback
	 *   Callback to be wrapped.
	 */
	public function __construct(Closure $callback) {
		$this->_callback = $callback;
	}

	/**
	 * Clear the entire result storage for the callback.
	 *
	 * @api
	 * @since 0.1.0
	 *
	 * @return $this
	 */
	public function clear() {
		$this->_storage = array();
		return $this;
	}

	/**
	 * Clean cache result matching given arguments.
	 *
	 * @api
	 * @since 0.1.0
	 *
	 * @param string ...$args
	 *   No arguments will clear the empty argument result.
	 *
	 *   The arguments should match the callback invocation arguments. It will
	 *   be hashed and returned.
	 * @return $this
	 */
	public function clean() {
		if (func_num_args() < 1) {
			unset($this->_storage[self::NO_ARGS_KEY]);
			return $this;
		}

		unset($this->_storage[ hash_array(func_get_args()) ]);
		return $this;
	}

	public function __invoke() {
		$args = array();
		$hash = self::NO_ARGS_KEY;

		if (func_num_args() > 0) {
			$args = func_get_args();
			$hash = hash_array($args);
		}

		if (array_key_exists($hash, $this->_storage)) {
			return $this->_storage[$hash];
		}

		$this->_storage[$hash] = call_user_func_array($this->_callback, $args);
		return $this->_storage[$hash];
	}
}
