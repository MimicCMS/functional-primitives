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
 * Iterate through each element of collection passing to callback.
 *
 * Each element in the returned array will have an index matched to the original
 * array index.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function map($collection, $callback) {
	$values = array();
	foreach ($collection as $index => $element) {
		$values[ $index ] = $callback($element, $index, $collection);
	}
	return $values;
}

/**
 * Iterate through each element of collection passing to callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return void
 */
function each($collection, $callback) {
	foreach ($collection as $index => $element) {
		$callback($element, $index, $collection);
	}
}

/**
 * Iterate through each element of collection to reduce to a single value.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param mixed $initial
 * @param ReduceCollectionCallback|callable $callback
 * @return mixed
 */
function reduce($collection, $initial, $callback) {
	foreach ($collection as $index => $element) {
		$initial = $callback($element, $initial, $index, $collection);
	}
	return $initial;
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
 * Drop elements in collection up to when callback is false.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function dropFirst($collection, $callback) {
	$keep = array();
	$drop = true;
	each($collection, function($element, $index, $collection) use (&$keep, &$drop, $callback) {
		if ( ! $callback($element, $index, $collection) ) {
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
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function dropLast($collection, $callback) {
	$keep = array();
	$drop = true;
	each($collection, function($element, $index, $collection) use (&$keep, &$drop, $callback) {
		if ( $drop && $callback($element, $index, $collection) ) {
			$drop = false;
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
	if ( $callback === null ) {
		reset($collection);
		return current($collection);
	}

	foreach ( $collection as $index => $element ) {
		if ( $callback($element, $index, $collection) ) {
			return $element;
		}
	}

	return null;
}

/**
 * First index in collection matching value, using value as callback if
 * available.
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

function flatMap() {
	/** @todo Incomplete */
}

function flatten() {
	/** @todo Incomplete */
}

/**
 * Groups a collection by callback.
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
 * Invoke method on class on collection passing all results.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array<string|object> $collection
 *   It is possible to call both class methods by passing strings and instance
 *   methods by passing objects or both by mixing both types as long as the
 *   method exists in the class.
 * @param string $methodName
 * @param array<mixed> $arguments
 *   This is passed to the new callback based on collection element and given
 *   method name.
 * @return array<mixed>
 */
function invoke($collection, $methodName, array $arguments = array()) {
	return map($collection, function($element) use ($methodName, $arguments) {
		return invokeIf($element, $methodName, $arguments);
	});
}

/**
 * Retrieve result from first successful method call on object from collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array<string|object> $collection
 *   It is possible to call both class methods by passing strings and instance
 *   methods by passing objects or both by mixing both types as long as the
 *   method exists in the class.
 * @param string $methodName
 * @param array<mixed> $arguments
 *   This is passed to the new callback based on collection element and given
 *   method name.
 * @return mixed
 */
function invokeFirst($collection, $methodName, array $arguments = array()) {
	$callback = function($element) use ($methodName) {
		return is_callable(array($element, $methodName));
	};
	return invokeIf(first($collection, $callback), $methodName, $arguments);
}

/**
 * Invoke method on object if callable and return result or default.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param object|string $object
 * @param string $methodName
 * @param array $arguments
 * @param mixed $default
 *   Optional. Default is null. Will be callback, if not callable.
 * @return mixed
 */
function invokeIf($object, $methodName, array $arguments = array(), $default = null) {
	$callback = array($object, $methodName);
	if ( ! is_callable($callback) ) {
		return $default;
	}
	return call_user_func_array($callback, $arguments);
}

/**
 * Retrieve result from last successful method call on object from collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array<string|object> $collection
 *   It is possible to call both class methods by passing strings and instance
 *   methods by passing objects or both by mixing both types as long as the
 *   method exists in the class.
 * @param string $methodName
 * @param array<mixed> $arguments
 *   This is passed to the new callback based on collection element and given
 *   method name.
 * @return mixed
 */
function invokeLast($collection, $methodName, array $arguments = array()) {
	return invokeFirst(array_reverse($collection, true), $methodName, $arguments);
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
	return first(array_reverse($collection, true), $callback);
}

/**
 * Last index in collection matching value, using value as callback if
 * available.
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
	return firstIndexOf(array_reverse($collection, true), $value, $strict);
}

/**
 * Separates a collection by callback into truthy and falsy parts.
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

function pick() {
	/** @todo Incomplete */
}

function pluck() {
	/** @todo Incomplete */
}

function reduceLeft() {
	/** @todo Incomplete */
}

function reduceRight() {
	/** @todo Incomplete */
}

/**
 * Remove elements from collection that pass callback.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function reject($collection, $callback) {
	return filter($collection, negate($callback));
}

/**
 * Remove elements from collection that do not pass callback.
 *
 * @api
 * @since 0.1.0
 * @link \Mimic\Functional\filter() Alias of filter.
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function select($collection, $callback) {
	return filter($collection, $callback);
}

function some() {
	/** @todo Incomplete */
}

function sort() {
	/** @todo Incomplete */
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

function unique() {
	/** @todo Incomplete */
}

function zip() {
	/** @todo Incomplete */
}
