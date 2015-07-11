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
 * Whether every element in collection passes callback evaluation.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return boolean
 *   All elements must pass evaluation for true to be returned.
 */
function every($collection, $callback) {
	return short($collection, false, true, function($element, $index, $collection) use ($callback) {
		return ! $callback($element, $index, $collection);
	});
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
 * Whether collection has index.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param string|int $key
 * @return boolean
 */
function has($collection, $key) {
	return short($collection, true, false, function($_, $index) use ($key) {
		return $index === $key;
	});
}

/**
 * Whether none of the elements in collection passes callback evaluation.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return boolean
 *   All elements must fail evaluation for true to be returned.
 */
function none($collection, $callback) {
	return short($collection, false, true, function($element, $index, $collection) use ($callback) {
		return $callback($element, $index, $collection);
	});
}

/**
 * Iterate through collection short-circuiting when callback returns true.
 *
 * This prevents the entire loop from executing for some performance. At worst,
 * every element will be evaluated.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param mixed $passed
 *   This value is returned when evaluation returns true.
 * @param mixed $default
 *   This value is returned when loop finishes with no evaluation passing.
 * @param MapCollectionCallback|callable $callback
 * @return mixed
 */
function short($collection, $passed, $default, $callback) {
	foreach ($collection as $index => $element) {
		if ( $callback($element, $index, $collection) ) {
			return $passed;
		}
	}
	return $default;
}

/**
 * Whether some of the elements in collection match callback.
 *
 * This will short-circuit the loop, returning true immediately on the first
 * element where the callback is true.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return bool
 */
function some($collection, $callback) {
	return short($collection, true, false, $callback);
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
