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
		return null;
	}
	$callbacks = func_get_args();
	return function() use ($callbacks) {
		$arguments = func_get_args();
		$func = array_unshift($callbacks);
		$result = call_user_func_array($func, $arguments);

		foreach ( $callbacks as $callback ) {
			$result = $callback($result);
		}

		return $result;
	};
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
	$outerArguments = array_slice(func_get_args(), 2);
	return function($object) use ($methodName, $default, $outerArguments) {
		if ( ! is_callable(array($object, $methodName)) ) {
			return $default;
		}
		$innerArguments = array_slice(func_get_args(), 1);
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
	$innerArguments = func_get_args();
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
