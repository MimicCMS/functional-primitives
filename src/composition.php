<?php
/**
 * @package Mimic\Functional
 * @since 0.1.0
 * @license MIT
 *
 * @typedef MapCollectionCallback \Closure {
 *     @param mixed $element
 *       Item in the collection.
 *     @param string|int $index
 *       Index of element in the collection.
 *     @param \Traversable|array $collection
 *       Collection. Writes to collection will not do anything.
 *     @return mixed
 * }
 *
 * @typedef ReduceCollectionCallback \Closure {
 *     @param mixed $element
 *       Item in the collection.
 *     @param mixed $current
 *       Current value after modification.
 *     @param string|int $index
 *       Index of element in the collection.
 *     @param \Traversable|array $collection
 *       Collection. Writes to collection will not do anything.
 *     @return mixed
 * }
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

use Closure;

function compose() {
	/** @todo Incomplete */
}

/**
 * Mutates or accesses implementation based on name.
 *
 * @param string $name
 *   It is better to namespace and set the name to something that won't conflict
 *   with other requirements.
 * @param callable|bool $callback
 *   Optional. Setting this value will override whatever implementation is
 *   currently set for the name.
 *
 *   Setting callback to false will remove implementation.
 * return callable
 */
function implementation($name, $callback = null) {
	static $_store = array();

	if ( $callback !== null ) {
		$_store[ $name ] = $callback;
	}
	else if ( $callback === false ) {
		unset($_store[ $name ]);
	}

	return $_store[ $name ];
}

function partialAny() {
	/** @todo Incomplete */
}

function partialLeft() {
	/** @todo Incomplete */
}

function partialRight() {
	/** @todo Incomplete */
}

function pipeline() {
	/** @todo Incomplete */
}

/**
 * Wrap callback in a closure.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param callback $callback
 *   Every callback type is supported. Arguments will be passed to callback, if any exist.
 * @param mixed ...$args
 *   Arguments to pass to callback.
 * @return Closure {
 *     @return mixed
 * }
 */
function wrap($callback) {
	$arguments = array();
	if (func_num_args() > 1) {
		$arguments = array_slice(func_get_args(), 1);
	}
	return function() use ($callback, $arguments) {
		return call_user_func_array($callback, $arguments);
	};
}
