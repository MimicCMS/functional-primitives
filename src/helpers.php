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

/**
 * Hashes an array preventing closures from throwing errors.
 *
 * This is not really part of the API and you should probably use something else
 * if you want this implemented correctly. It is not tuned for performance.
 *
 * @since 0.1.0
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

/**
 * When reversing arrays, you need to fix the map collection callable.
 *
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return MapCollectionCallback|callable
 */
function passOriginalCollection($collection, $callback) {
	return function($element, $index) use ($collection, $callback) {
		return $callback($element, $index, $collection);
	};
}

/**
 * Basic sort comparison that encompasses the most common user sorting.
 *
 * @api
 * @since 0.1.0
 *
 * @param boolean $strict
 * @param boolean $reversed
 *   Whether to reverse the order.
 * @return \Closure {
 *    Compare left to right.
 *    @param mixed $left
 *    @param mixed $right
 *    @return int
 *       Return 0 for same, -1 for
 * }
 */
function sortable($reversed = false) {
	return function($left, $right) use ($reversed) {
		if ( !is_scalar($left) || !is_scalar($right) ) {
			if ( !is_scalar($left) && !is_scalar($right) ) {
				return 0;
			}
			$order = !is_scalar($left) ? 1 : -1;
			return $reversed ? $order * -1 : $order;
		}
		if ($left == $right) {
			return 0;
		}
		if (is_string($left) || is_string($right)) {
			$order = strnatcasecmp($left, $right) > 0 ? 1 : -1;
		}
		else {
			$order = $left < $right ? -1 : 1;
		}
		return $reversed ? $order * -1 : $order;
	};
}
