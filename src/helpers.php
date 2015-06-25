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
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

use Closure;
use Traversable;

/**
 * Whether value exists in collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param mixed $value
 * @param boolean $strict
 * @return boolean
 */
function contains($collection, $value, $strict = false) {
	return short($collection, true, false, compare($value, $strict));
}

/**
 * Whether all elements in collection are identical to false.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @return boolean
 */
function false($collection) {
	return every($collection, compare(false, true));
}

/**
 * Whether every item in a collection contains values that evaluate to false.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @return boolean
 */
function falsy($collection) {
	return every($collection, compare(false, false));
}

/**
 * Whether all elements in collection are identical to true.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @return boolean
 */
function true($collection) {
	return every($collection, compare(true, true));
}

/**
 * Whether every item in a collection contains values that evaluate to true.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @return boolean
 */
function truthy($collection) {
	return every($collection, compare(true, false));
}

/**
 * Passes through value, unless callback then returns result of callback.
 *
 * This is also useful when initializing classes on PHP5.3. Not really that
 * useful on PHP5.4.
 *
 * @api
 * @since 0.1.0
 *
 * @param mixed|callable $value
 *   If value is a callback, then it is called without any arguments. Not all
 *   callbacks are supported. Array callbacks will fail.
 * @return mixed
 */
function value($value) {
	if ( is_callable($value) ) {
		$value = $value();
	}
	return $value;
}

/**
 * Apply callback to value and get result.
 *
 * You should use {@link \Mimic\Functional\value()} instead of this function
 * when you are not using a callback. This includes object initialization.
 *
 * This function does not match Laravel `with()` definition, but you can still
 * use {@link \Mimic\Functional\value()}, which does the same thing.
 *
 * @api
 * @since 0.1.0
 *
 * @param mixed $value
 *   If value is a callback, then it is called without any arguments.
 * @param callable $callback
 * @return mixed
 */
function with($value, $callback) {
	return $callback(value($value));
}

/**
 * Memorize caches the result for a given set of arguments.
 *
 * Functions or callbacks that use this must have pure functions or callbacks
 * that return the same result every time the same set of arguments are passed.
 * Not following this will break the execution of the process and given
 * inaccurate results.
 *
 * @api
 * @since 0.1.0
 *
 * @todo Needs tests.
 *
 * @param callback $callback
 * @return MemoizeCache
 */
function memoize($callback) {
	return new MemoizeCache($callback);
}

/**
 * Whether collection element fails callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param MapCollectionCallback|callable
 * @return MapCollectionCallback|callable
 */
function fails($callback) {
	return negate($callback);
}

/**
 * Whether collection element passes callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param MapCollectionCallback|callable
 * @return MapCollectionCallback|callable
 */
function succeeds($callback) {
	return function($element, $index, $collection) use ($callback) {
		return !! $callback($element, $index, $collection);
	};
}

/**
 * Negate result of collection item callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param MapCollectionCallback|callable
 * @return MapCollectionCallback|callable
 */
function negate($callback) {
	return function($element, $index, $collection) use ($callback) {
		return ! $callback($element, $index, $collection);
	};
}

/**
 * Comparison function which checks whether the element matches given value.
 *
 * @api
 * @since 0.1.0
 *
 * @param mixed $value
 * @param boolean $strict
 * @return MapCollectionCallback|callable
 */
function compare($value, $strict = false) {
	return function($element) use ($value, $strict) {
		return $value === $element || (!$strict && $value == $element);
	};
}

/**
 * Hashes an array preventing closures from throwing errors.
 *
 * This is not really part of the API and you should probably use something else
 * if you want this implemented correctly. It is not tuned for performance.
 *
 * @api
 * @since 0.1.0
 *
 * @todo Needs tests.
 *
 * @param array<mixed> $args
 * @return string
 */
function hash_array(array $args = array()) {
	$serializableArgs = array();
	foreach ( $args as $arg ) {
		if (is_object($arg) || $arg instanceof Closure) {
			$serializableArgs[] = get_class($arg) .':'. spl_object_hash($arg);
		}
		else if (is_array($arg)) {
			$serializableArgs[] = hash_array($arg);
		}
		else {
			$serializableArgs[] = $arg;
		}
	}

	return json_encode($serializableArgs);
}


