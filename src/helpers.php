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

/**
 * Whether value exists in collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param \Traversable|array $collection
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
 * @param \Traversable|array $collection
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
 * @param \Traversable|array $collection
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
 * @param type $collection
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
 * @param type $collection
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
 * @param \Closure $callback
 * @return mixed
 */
function with($value, \Closure $callback) {
	return $callback(value($value));
}

/**
 * Negate result of collection item callback.
 *
 * @param MapCollectionCallback|\Closure
 * @return MapCollectionCallback|\Closure
 */
function not(\Closure $callback) {
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
 * @return MapCollectionCallback|\Closure
 */
function compare($value, $strict = false) {
	return function($element) use ($value, $strict) {
		return $value === $element || (!$strict && $value == $element);
	};
}


