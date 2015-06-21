<?php
/**
 * @package Mimic\Functional
 * @since 0.1.0
 * @license MIT
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

/**
 * Whether value exists in collection.
 *
 * @param \Traversable|array $collection
 * @param mixed $value
 * @param boolean $strict
 * @return boolean
 */
function contains($collection, $value, $strict = false) {
	return short($collection, true, false, function($element) use ($value, $strict) {
		return $value === $element || (!$strict && $value == $element);
	});
}

/**
 * Whether all elements in collection are identical to false.
 *
 * @param \Traversable|array $collection
 * @return boolean
 */
function false($collection) {
	return contains($collection, false, true);
}

/**
 * Whether every item in a collection contains values that evaluate to false.
 *
 * @param \Traversable|array $collection
 * @return boolean
 */
function falsy($collection) {
	return contains($collection, false, false);
}

/**
 * Whether all elements in collection are identical to true.
 *
 * @param type $collection
 * @return boolean
 */
function true($collection) {
	return contains($collection, true, true);
}

/**
 * Whether every item in a collection contains values that evaluate to true.
 *
 * @param type $collection
 * @return boolean
 */
function truthy($collection) {
	return contains($collection, true, false);
}

/**
 * Passes through value, unless callback then returns result of callback.
 *
 * This is also useful when initializing classes on PHP5.3. Not really that
 * useful on PHP5.4.
 *
 * @param mixed|\Closure $value
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
 * when you are not using a callback. This includes
 *
 * @param mixed $value
 *   If value is a callback, then it is called without any arguments.
 * @param \Closure $callback
 * @return mixed
 */
function with($value, \Closure $callback) {
	return $callback(value($value));
}


