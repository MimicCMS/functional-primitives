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
 * Hashes an array preventing closures from throwing errors.
 *
 * This is not really part of the API and you should probably use something else
 * if you want this implemented correctly. It is not tuned for performance.
 *
 * @since 0.1.0
 *
 * @todo Needs tests.
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
 * Put value onto object or array by name.
 *
 * This works with both objects and arrays. Other types will simply be returned
 * with no modifications.
 *
 * @api
 * @since 0.1.0
 * @todo Needs tests.
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
	if ( is_object($something) && property_exists($something, $name) ) {
		$copy = clone $something;
		if ( $copy->{$name} === null || $override ) {
			$copy->{$name} = $value;
		}
		return $copy;
	}

	if ( is_array($something) && ( !array_key_exists($name, $something) || $override ) ) {
		$something[$name] = $value;
	}

	return $something;
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
 * @param mixed|callable $value
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
 * @param callable $callback
 * @return mixed
 */
function with($value, $callback) {
	return $callback(value($value));
}
