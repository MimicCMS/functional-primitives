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
 * Split the collection into separate arrays for indexes and values.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @link http://laravel.com/docs/master/helpers#method-array-divide
 *
 * @param Traversable|array $collection
 * @return array
 *   [0] are the collection indexes and [1] are the collection values.
 */
function divide($collection) {
	if ($collection instanceof Traversable) {
		$collection = iterator_to_array($collection);
	}
	return array(
		array_keys($collection),
		array_values($collection)
	);
}

/**
 * Drop elements in collection up to when callback is false.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function dropFirst($collection, $callback) {
	$keep = array();
	$drop = true;
	each($collection, function($element, $index, $collection) use (&$keep, &$drop, $callback) {
		if ( $drop && ! $callback($element, $index, $collection) ) {
			$drop = false;
		}
		if ( ! $drop ) {
			$keep[ $index ] = $element;
		}
	});
	return $keep;
}

/**
 * Drop all elements in collection after callback returns true.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function dropLast($collection, $callback) {
	$keep = array();
	$drop = false;
	each($collection, function($element, $index, $collection) use (&$keep, &$drop, $callback) {
		if ( ! $drop && $callback($element, $index, $collection) ) {
			$drop = true;
		}
		if ( ! $drop ) {
			$keep[ $index ] = $element;
		}
	});
	return $keep;
}

/**
 * Remove elements from collection that do not pass callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function filter($collection, $callback) {
	$aggregation = array();
	each($collection, function($element, $index, $collection) use (&$aggregation, $callback) {
		if ( $callback($element, $index, $collection) ) {
			$aggregation[ $index ] = $element;
		}
	});
	return $aggregation;
}

/**
 * Retrieve first item in collection or first item that passes callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Optional. If not given, then will simply return first item in collection.
 * @return mixed
 *   Default return value is null. It is technically not possible to tell
 *   whether none of the elements evaluated to true from this function alone.
 */
function first($collection, $callback = null) {
	// Do not break the state of collection, by changing the internal
	// pointer.
	$copy = $collection;
	reset($copy);
	if ( $callback === null ) {
		return current($copy);
	}

	foreach ( $copy as $index => $element ) {
		if ( $callback($element, $index, $collection) ) {
			return $element;
		}
	}

	return null;
}

/**
 * Groups a collection by callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Callback must return either a string or numeric value.
 * @return array
 */
function group($collection, $callback) {
	$groups = array();
	each($collection, function($element, $index, $collection) use (&$groups, $callback) {
		$group = $callback($element, $index, $collection);
		$groups[$group][$index] = $element;
	});
	return $groups;
}

/**
 * Retrieve first item in collection or first item that passes callback.
 *
 * @api
 * @since 0.1.0
 * @link \Mimic\Functional\first()
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Optional. If not given, then will simply return first item in collection.
 * @return mixed
 *   Default return value is null. It is technically not possible to tell
 *   whether none of the elements evaluated to true from this function alone.
 */
function head($collection, $callback = null) {
	return first($collection, $callback);
}

/**
 * Exclude the given amount from the end of the collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Need to add to guide documentation.
 *
 * @param Traversable|array $collection
 * @param int $ignore
 *   Must be positive. Will take from end.
 * @return array
 */
function initial($collection, $ignore) {
	$array = $collection;
	if (is_object($collection) && $collection instanceof Traversable) {
		$array = iterator_to_array($collection);
	}
	$fromEnd = -1 * abs($ignore);
	return array_slice($array, 0, $fromEnd, true);
}

/**
 * Retrieve last item in collection or last item that passes callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Optional. If not given, then will simply return first item in collection.
 * @return mixed
 *   Default return value is null. It is technically not possible to tell
 *   whether none of the elements evaluated to true from this function alone.
 */
function last($collection, $callback = null) {
	$closure = null;
	if ($callback !== null) {
		$closure = passOriginalCollection($collection, $callback);
	}
	return first(array_reverse($collection, true), $closure);
}

/**
 * Keep only the given elements that match given indexes.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @link http://laravel.com/docs/master/helpers#method-array-only
 *
 * @param Traversable|array $collection
 * @param array $keep
 *   List of indexes.
 * @return array
 *   Array of elements in collection that are in keys list.
 */
function only($collection, array $keep) {
	return filter($collection, function($_, $index) use ($keep) {
		return in_array($index, $keep, true);
	});
}

/**
 * Separates a collection by callback into truthy and falsy parts.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Callback must return boolean.
 * @return array
 *   Array contains the keys '0' and '1'. Truthy part is in '1' and falsy part
 *   is in '0'.
 */
function partition($collection, $callback) {
	return group($collection, function($element, $index, $collection) use ($callback) {
		return $callback($element, $index, $collection) ? 1 : 0;
	});
}

/**
 * Exclude the given amount from the beginning of the collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Need to add to guide documentation.
 *
 * @param Traversable|array $collection
 * @param int $from
 *   Must be positive. Will take from beginning.
 *   Obviously, this must be less than
 * @return array
 */
function rest($collection, $from) {
	$array = $collection;
	if (is_object($collection) && $collection instanceof Traversable) {
		$array = iterator_to_array($collection);
	}
	return array_slice($array, abs($from), count($array), true);
}

/**
 * Retrieve last item in collection or last item that passes callback.
 *
 * @api
 * @since 0.1.0
 * @link \Mimic\Functional\last()
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 *   Optional. If not given, then will simply return first item in collection.
 * @return mixed
 *   Default return value is null. It is technically not possible to tell
 *   whether none of the elements evaluated to true from this function alone.
 */
function tail($collection, $callback = null) {
	return last($collection, $callback);
}

/**
 * Pull unique values from a collection using an optional callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param boolean $strict
 *   Optional. Default is true. Whether check should use strict comparison.
 * @param MapCollectionCallback|callable|null $callback
 *   Optional. If given, element will be passed to callback for the key to check
 *   against whether it is unique.
 * @return array
 */
function unique($collection, $strict = true, $callback = null) {
	$existing = array();
	return filter($collection, function($element, $index, $collection) use ($callback, $strict, &$existing) {
		if ( is_callable($callback) ) {
			$key = $callback($element, $index, $collection);
		}
		else {
			$key = $element;
		}

		if ( ! in_array($key, $existing, $strict) ) {
			$existing[] = $key;
			return true;
		}
		return false;
	});
}
