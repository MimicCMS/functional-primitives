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
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-except
 */
function except() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function flattenSingle($collection, $callback) {
	$flatten = array();
	each($collection, function($element, $index, $collection) use (&$flatten, $callback) {
		$result = $callback($element, $index, $collection);
		if ( is_array($result) || $result instanceof Traversable ) {
			foreach ( $result as $item ) {
				$flatten[] = $item;
			}
			return;
		}
		$flatten[] = $result;
	});
	return $flatten;
}

/**
 * Flatten collection to a single dimension array.
 *
 * Does not preserve indexes.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @param array
 */
function flattenRecursive($collection) {
	$flatten = array();
	each($collection, function($element) use (&$flatten) {
		if (is_array($element) || $element instanceof Traversable) {
			foreach ( flattenRecursive($element) as $item ) {
				$flatten[] = $item;
			}
			return;
		}
		$flatten[] = $element;
	});
	return $flatten;
}

/**
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-dot
 */
function flattenDot() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forget() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forgetFirst() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-forget
 */
function forgetLast() {
	/** @todo Incomplete */
}

/**
 *
 * @api
 * @since 0.1.0
 * @link http://laravel.com/docs/master/helpers#method-array-get
 */
function get() {
	/** @todo Incomplete */
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
 *
 * @param Traversable|array $collection
 * @param ReduceCollectionCallback|callable $callback
 * @param mixed $initial
 *   Optional. Default to null.
 * @return mixed
 */
function reduceRight($collection, $callback, $initial = null) {
	return reduce(
		array_reverse($collection, true), $initial,
		function($element, $initial, $index) use ($collection, $callback) {
			return $callback($element, $initial, $index, $collection);
		}
	);
}

/**
 * Remove elements from collection that pass callback.
 *
 * @api
 * @since 0.1.0
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
 *
 * @param Traversable|array $collection
 * @param MapCollectionCallback|callable $callback
 * @return array
 */
function select($collection, $callback) {
	return filter($collection, $callback);
}

/**
 * Amount of elements in a collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param Traversable|array $collection
 * @return int
 */
function size($collection) {
	if ( !is_object($collection) && !is_array($collection) ) {
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
 * Sorts a collection with a user-defined function, optionally perserving keys.
 *
 * @api
 * @since 0.1.0
 *
 * @link https://github.com/lstrojny/functional-php See src/Functional/Sort.php
 * @license MIT
 * @copyright 2011-2015 Lars Strojny <lstrojny@php.net>
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
function sort($collection, $callback, $preserveKeys = false) {
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

function without() {
	/** @todo Incomplete */
}

function zip() {
	/** @todo Incomplete */
}
