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

use Closure;
use Traversable;

/**
 * Execute single callback with optional arguments.
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $callback
 * @param mixed ...$args
 * @return mixed
 */
function apply($callback) {
	if ( func_num_args() === 1 ) {
		return $callback();
	}
	return call_user_func_array($callback, array_slice(func_get_args(), 1));
}

/**
 * Execute callback when test callback passed.
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $callback
 * @param callable $test
 * @return Closure {
 *     @return boolean|mixed
 *       False on failure.
 * }
 */
function attempt($callback, $test) {
	return function() use ($test, $callback) {
		if ($test() === false) {
			return false;
		}
		return $callback();
	};
}

/**
 * Compose executes callbacks passing each result to the next callback.
 *
 * If you pass callbacks `f` and `g`, then the result will be g(f()).
 *
 * @api
 * @since 0.1.0
 * @link \Mimic\Functional\pipeline
 *   Similar function that executes in reverse order.
 *
 * @param callable ...$callbacks
 *   The first callback will receive arguments from the closure, if any. All
 *   remaining callbacks must only accept one argument, because only one
 *   argument will be passed.
 * @return Closure {
 *     @param mixed ...$arguments
 *       These will be passed to the first callback.
 *     @return mixed
 * }
 */
function compose() {
	if (func_num_args() < 1) {
		return function() { return null; };
	}

	$callbacks = func_get_args();
	return function() use ($callbacks) {
		$arguments = func_get_args();
		$callback = array_shift($callbacks);
		$result = call_user_func_array($callback, $arguments);

		foreach ( $callbacks as $callback ) {
			$result = $callback($result);
		}

		return $result;
	};
}

/**
 * Executes left callback and if it fails will execute the right callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $left
 * @param callable $right
 * @return Closure {
 *     @return mixed
 * }
 */
function either($left, $right) {
	return function() use ($left, $right) {
		$value = $left();
		if ($value !== false) {
			return $value;
		}
		return $right();
	};
}

/**
 * Execute callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param callable ...$args
 * @return array<mixed>
 */
function execute() {
	if (func_num_args() < 1) {
		return array();
	}

	return map(func_get_args(), function($element) {
		if ( is_callable($element) ) {
			return apply($element);
		}
		return null;
	});
}

/**
 * Mutates or accesses implementation based on name.
 *
 * @api
 * @since 0.1.0
 *
 * @param string $name
 *   It is better to namespace and set the name to something that won't conflict
 *   with other requirements.
 * @param callable|bool $callback
 *   Optional. Setting this value will override whatever implementation is
 *   currently set for the name.
 *
 *   Setting callback to false will remove implementation.
 * return callable
 */
function implementation($name, $callback = null) {
	static $_store = array();

	if ( $callback === false ) {
		unset($_store[ $name ]);
	}
	else if ( $callback !== null ) {
		$_store[ $name ] = $callback;
	}

	return isset($_store[ $name ]) ? $_store[ $name ] : null;
}

/**
 * Invoke method on class on collection passing all results.
 *
 * @api
 * @since 0.1.0
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
 * Memorize caches the result for a given set of arguments.
 *
 * Functions or callbacks that use this must have pure functions or callbacks
 * that return the same result every time the same set of arguments are passed.
 * Not following this will break the execution of the process and given
 * inaccurate results.
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $callback
 * @return MemoizeCache
 */
function memoize($callback) {
	static $_container = array();

	$hash = hash_array(array($callback));

	if ( ! isset($_container[ $hash ]) ) {
		$_container[ $hash ] = new MemoizeCache($callback);
	}

	return $_container[ $hash ];
}

/**
 * Negate result of collection item callback.
 *
 * @api
 * @since 0.1.0
 *
 * @param MapCollectionCallback|callable
 * @return MapCollectionCallback|callable
 */
function negate($callback) {
	return function($element, $index, $collection) use ($callback) {
		return ! $callback($element, $index, $collection);
	};
}

function partialAny() {
	/** @todo Incomplete */
}

/**
 * Apply partial arguments to callback from the left.
 *
 * The arguments called in the returned closure will be applied first and then
 * the arguments passed in the `partialLeft()` will be applied.
 *
 *     $callback = partialLeft('array_sum', 1, 2);
 *     $result = $callback(3, 4, 5);
 *     // $result is array_sum(3, 4, 5, 1, 2);
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $callback
 * @param mixed ...$arguments
 *   These will be applied last to the callback.
 * @return Closure {
 *     Call will execute with arguments combined.
 *
 *     @param mixed ...$arguments
 *       These will be applied first to callback.
 *     @return mixed
 * }
 */
function partialLeft($callback) {
	$outerArguments = array_slice(func_get_args(), 1);
	return function() use ($callback, $outerArguments) {
		$innerArguments = func_get_args();
		return call_user_func_array($callback, array_merge($innerArguments, $outerArguments));
	};
}

/**
 * Execute method on object along with parameters.
 *
 * @api
 * @since 0.1.0
 *
 * @param string $methodName
 * @param mixed $default
 *   Returned when object and method name are not callable. Meaning object does
 *   not have a method with that name or matching the execution. Care must be
 *   taken that the correct instance or class method exists. PHP may decide that
 *   it is acceptable to execute an object that is a string along with the
 *   method that exists. If the method is in fact instance method, then
 *   execution will result in an error. Likewise with the reverse.
 * @param mixed ...$arguments
 *   These will be applied last to the callback.
 * @return Closure {
 *     Call will execute on object with original method.
 *
 *     @param string|object $object
 *     @param mixed ...$arguments
 *       These will be applied first to callback.
 *     @return mixed
 * }
 */
function partialMethod($methodName, $default = null) {
	$innerArguments = array_slice(func_get_args(), 2);
	return function($object) use ($methodName, $default, $innerArguments) {
		if ( ! is_callable(array($object, $methodName)) ) {
			return $default;
		}
		$outerArguments = array_slice(func_get_args(), 1);
		return call_user_func_array(array($object, $methodName), array_merge($innerArguments, $outerArguments));
	};
}

/**
 * Apply partial arguments to callback from the right.
 *
 * The arguments passed to this function will be first and the arguments passed
 * in the return closure will be called last.
 *
 *     $callback = partialLeft('array_sum', 1, 2);
 *     $result = $callback(3, 4, 5);
 *     // $result is array_sum(1, 2, 3, 4, 5);
 *
 * @api
 * @since 0.1.0
 *
 * @param callable $callback
 * @param mixed ...$arguments
 *   These will be applied first to the callback.
 * @return Closure {
 *     Call will execute with arguments combined.
 *
 *     @param mixed ...$arguments
 *       These will be applied last to callback.
 *     @return mixed
 * }
 */
function partialRight($callback) {
	$innerArguments = array_slice(func_get_args(), 1);
	return function() use ($callback, $innerArguments) {
		$outerArguments = func_get_args();
		return call_user_func_array($callback, array_merge($innerArguments, $outerArguments));
	};
}

/**
 * Pipeline executes callbacks in the order they are in the arguments.
 *
 * If you pass callbacks `f` and `g`, then the result will be f(g()).
 *
 * @api
 * @since 0.1.0
 * @link \Mimic\Functional\compose
 *   Similar function that executes in reverse order.
 *
 * @param callable ...$callbacks
 * @return Closure {
 *     @param mixed ...$arguments
 *       These will be passed to the last callback.
 *     @return mixed
 * }
 */
function pipeline() {
	return call_user_func_array(__NAMESPACE__.'\compose', array_reverse(func_get_args()));
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

/**
 * Wrap callback in a closure.
 *
 * @api
 * @since 0.1.0
 *
 * @param callback $callback
 *   Every callback type is supported. Arguments will be passed to callback, if any exist.
 * @param mixed ...$args
 *   Arguments to pass to callback.
 * @return Closure {
 *     @return mixed
 * }
 */
function wrap($callback) {
	$arguments = array();
	if (func_num_args() > 1) {
		$arguments = array_slice(func_get_args(), 1);
	}
	return function() use ($callback, $arguments) {
		return call_user_func_array($callback, $arguments);
	};
}
