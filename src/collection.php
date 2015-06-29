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
use Countable;

function clean() {
	/** @todo Complete */
}

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
 * @todo Needs tests.
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
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-except
 */
function except() {
	/** @todo Incomplete */
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
 * @api
 * @since 0.1.0
 * @todo Needs tests.
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
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-dot
 */
function flattenDot() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forget() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forgetFirst() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forgetLast() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Complete
 * @link http://laravel.com/docs/master/helpers#method-array-get
 */
function get() {
	/** @todo Incomplete */
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
 * Whether collection has index.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
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
 * List of all indexes that match elements in a collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Need to add to guide documentation.
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
	return array_slice($array, 0, (-1 * abs($ignore)), true);
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
 * @api
 * @since 0.1.0
 * @todo Needs tests.
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
		return in_array($index, $keep);
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

function pick() {
	/** @todo Incomplete */
}

function pluck() {
	/** @todo Incomplete */
}

function random() {
	/** @todo Incomplete */
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
 * Iterate through each element of collection to reduce to a single value.
 *
 * @api
 * @since 0.1.0
 * @todo Needs Tests.
 *
 * @param Traversable|array $collection
 * @param ReduceCollectionCallback|callable $callback
 * @param mixed $initial
 *   Optional. Default to null.
 * @return mixed
 */
function reduceLeft($collection, $callback, $initial = null) {
	return reduce($collection, $initial, $callback);
}

/**
 * Iterate through each element of collection to reduce to a single value.
 *
 * @api
 * @since 0.1.0
 * @todo Needs Tests.
 *
 * @param Traversable|array $collection
 * @param ReduceCollectionCallback|callable $callback
 * @param mixed $initial
 *   Optional. Default to null.
 * @return mixed
 */
function reduceRight($collection, $callback, $initial = null) {
	return reduce(array_reverse($collection, true), $initial, $callback);
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

/**
 * Mutate collection using dot notation to lookup indexes.
 *
 * This can modify both objects and arrays. It can also update combination of
 * objects and arrays. So it will attempt to either modify the property or index
 * value.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @link http://laravel.com/docs/master/helpers#method-array-set
 *
 * @param Traversable|array $collection
 * @param string $lookup
 * @param mixed $value
 * @return Traversable|array
 *   Copy of collection with modification applied.
 */
function set($collection, $lookup, $value) {
	$indexes = array($lookup);
	if (strpos('.', $lookup) !== false) {
		$indexes = explode('.');
	}

	$store = array($collection);
	$current = $collection;
	foreach ( array_slice($indexes, 0, -1) as $index ) {
		if ( is_object($current) && property_exists($current, $index) ) {
			$store[] = $current->{$index};
			$current = $current->{$index};
		}
		else if ( is_array($current) && array_key_exists($index, $current) ) {
			$store[] = $current[$index];
			$current = $current[$index];
		}
	}

	$index = array_pop($indexes);
	if ( is_object($current) && property_exists($current, $index) ) {
		$current->{$index} = $value;
	}
	else if ( is_array($current) && array_key_exists($index, $current) ) {
		$current[$index] = $value;
	}

	$build = $current;
	foreach (array_reverse($indexes) as $index) {
		$temp = array_pop($store);
		if ( is_object($temp) && property_exists($temp, $index) ) {
			$temp->{$index} = $build;
		}
		else if ( is_array($temp) && array_key_exists($index, $temp) ) {
			$temp[$index] = $build;
		}
		$build = $temp;
	}

	return $build;
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
 * Amount of elements in a collection.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
 * @todo Needs guide documentation.
 *
 * @param Traversable|array $collection
 * @return int
 */
function size($collection) {
	if ( !is_object($collection) || !is_array($collection) ) {
		return 0;
	}
	if (is_array($collection) || $collection instanceof Countable) {
		return count($collection);
	}
	if ($collection instanceof Traversable) {
		return count(iterator_to_array($collection));
	}
	return 0;
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
 * Sorts a collection with a user-defined function, optionally perserving keys.
 *
 * @api
 * @since 0.1.0
 *
 * @link https://github.com/lstrojny/functional-php See src/Functional/Sort.php
 * @license MIT
 * @copyright 2011-2015 Lars Strojny <lstrojny@php.net>
 *
 * @todo Needs tests.
 *
 * @param Traversable|array $collection
 * @param callable $callback {
 *     @param mixed $left
 *     @param mixed $right
 *     @param Traversable|array $collection
 *     @return int
 *       -1 to push to left, 0 for equal, or 1 to push to right.
 * }
 * @param boolean $preserveKeys
 *   Optional. Default is false.
 * @return array
 */
function sort($collection, callable $callback, $preserveKeys = false) {
    if ($collection instanceof Traversable) {
        $array = iterator_to_array($collection);
    } else {
        $array = $collection;
    }

    $fn = $preserveKeys ? 'uasort' : 'usort';
    $fn($array, function ($left, $right) use ($callback, $collection) {
        return $callback($left, $right, $collection);
    });
    return $array;
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

function without() {
	/** @todo Incomplete */
}

function zip() {
	/** @todo Incomplete */
}
