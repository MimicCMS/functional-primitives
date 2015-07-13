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

use ArrayAccess;

/**
 * Access value from collection by index.
 *
 * @param ArrayAccess|array $collection
 * @param string $index
 * @param mixed $default
 *   Optional. Defaults to null. What to return if doesn't exist.
 * @param callable $callback
 *   Check whether index exists.
 * @return mixed
 *   Value from collection with index.
 */
function pick($collection, $index, $default = null, $callback = null) {
	if ( (is_callable($callback) && !$callback($collection, $index)) || !isset($collection[$index]) ) {
		return $default;
	}
	return $collection[$index];
}

/**
 * Put value onto object or array by name.
 *
 * This works with both objects and arrays. Other types will simply be returned
 * with no modifications.
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-add
 *
 * @param object|array $something
 * @param string $name
 * @param mixed $value
 * @param boolean $override
 *   Optional. Default is false. Will allow for ignoring, if current value
 *   exists or overriding current value.
 * @return object|array
 *   Copy of something with new value.
 */
function put($something, $name, $value, $override = false) {
	if ( is_object($something) ) {
		$copy = clone $something;
		if ( !isset($copy->{$name}) || $override ) {
			$copy->{$name} = $value;
		}
		return $copy;
	}

	if ( is_array($something) && ( !array_key_exists($name, $something) || $override ) ) {
		$something[$name] = $value;
	}

	return $something;
}

