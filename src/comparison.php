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
 * First index in collection matching value, using value as callback if
 * available.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable|mixed $value
 *   A mixed value allows checking for the given value against element returning
 *   index in collection.
 * @param boolean $strict
 *   Optional. Defaults to true. Only used when value is mixed or not callable.
 * @return boolean|string|numeric
 *   False on failure.
 */
function firstIndexOf($collection, $value, $strict = true) {
	if ( is_callable($value) ) {
		foreach ( $collection as $index => $element ) {
			if ( $value($element, $index, $collection) ) {
				return $index;
			}
		}
		return false;
	}
	return firstIndexOf($collection, compare($value, $strict));
}

/**
 * List of all indexes that match elements in a collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable|mixed $value
 *   A mixed value allows checking for the given value against element returning
 *   index in collection.
 * @param boolean $strict
 *   Optional. Defaults to true. Only used when value is mixed or not callable.
 * @return boolean|string|numeric
 *   False on failure.
 */
function indexesOf($collection, $value, $strict = true) {
	if ( is_callable($value) ) {
		return array_keys(filter($collection, $value));
	}
	return indexesOf($collection, compare($value, $strict));
}

/**
 * Last index in collection matching value, using value as callback if
 * available.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable|mixed $value
 *   A mixed value allows checking for the given value against element returning
 *   index in collection.
 * @param boolean $strict
 *   Optional. Defaults to true. Only used when value is mixed or not callable.
 * @return boolean|string|numeric
 *   False on failure.
 */
function lastIndexOf($collection, $value, $strict = true) {
	if ( is_callable($value) ) {
		return firstIndexOf(array_reverse($collection, true), passOriginalCollection($collection, $value));
	}
	return firstIndexOf(array_reverse($collection, true), $value, $strict);
}
