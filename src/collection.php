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

/**
 * Iterate through each element of collection passing to callback.
 *
 * Each element in the returned array will have an index matched to the original
 * array index.
 *
 * @api
 * @since 0.1.0
 *
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return array
 */
function map($collection, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return void
 */
function each($collection, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param mixed $initial
 * @param ReduceCollectionCallback|\Closure $callback
 * @return mixed
 */
function reduce($collection, $initial, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param mixed $passed
 *   This value is returned when evaluation returns true.
 * @param mixed $default
 *   This value is returned when loop finishes with no evaluation passing.
 * @param MapCollectionCallback|\Closure $callback
 * @return mixed
 */
function short($collection, $passed, $default, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return boolean
 *   All elements must pass evaluation for true to be returned.
 */
function every($collection, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return boolean
 *   All elements must fail evaluation for true to be returned.
 */
function none($collection, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return array
 */
function dropFirst($collection, \Closure $callback) {
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
 * @param \Traversable|array $collection
 * @param MapCollectionCallback|\Closure $callback
 * @return array
 */
function dropLast($collection, \Closure $callback) {
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

function filter() {
	/** @todo Incomplete */
}

function first() {
	/** @todo Incomplete */
}

function firstIndexOf() {
	/** @todo Incomplete */
}

function flatMap() {
	/** @todo Incomplete */
}

function flatten() {
	/** @todo Incomplete */
}

function group() {
	/** @todo Incomplete */
}

function head() {
	/** @todo Incomplete */
}

function invoke() {
	/** @todo Incomplete */
}

function invokeFirst() {
	/** @todo Incomplete */
}

function invokeIf() {
	/** @todo Incomplete */
}

function invokeLast() {
	/** @todo Incomplete */
}

function last() {
	/** @todo Incomplete */
}

function lastIndexOf() {
	/** @todo Incomplete */
}

function memoize() {
	/** @todo Incomplete */
}

function partition() {
	/** @todo Incomplete */
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

function reject() {
	/** @todo Incomplete */
}

function select() {
	/** @todo Incomplete */
}

function some() {
	/** @todo Incomplete */
}

function sort() {
	/** @todo Incomplete */
}

function tail() {
	/** @todo Incomplete */
}

function unique() {
	/** @todo Incomplete */
}

function zip() {
	/** @todo Incomplete */
}
