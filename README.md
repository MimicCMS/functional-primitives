# Functional Library

[![Code Climate](https://codeclimate.com/github/SpeedySpec/phFunctional.png)](https://codeclimate.com/github/SpeedySpec/phFunctional)
[![Test Coverage](https://codeclimate.com/github/SpeedySpec/phFunctional/coverage.png)](https://codeclimate.com/github/SpeedySpec/phFunctional)
[![Build Status](https://travis-ci.org/SpeedySpec/phFunctional.svg?branch=master)](https://travis-ci.org/SpeedySpec/phFunctional)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SpeedySpec/phFunctional/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SpeedySpec/phFunctional/?branch=master)

Function primitives form a base of function composition allowing for reusable components.

## Upgrade Policy

Library uses [semantic versioning](http://semver.org), so that you should be able to upgrade supporting version 1. Version 2 will probably support different ways of function composition, using generators, coroutines and other available language constructs. Also, it will take lessons learned from using this library and apply better API. Later major versions will drop support for PHP5.3. The only reason PHP5.3 is supported, is that all of the code will run on PHP5.3 and to widen the amount of users that can develop using the library.

Library supports PHP5.3. Other versions of PHP are supported allowing for features in other versions.

## Installation

You may install this library using composer.

**TODO: Need to add composer configuration.**

## Inspirations

### Functional PHP Library

This library is inspired by Lars Strojny [Functional PHP](https://github.com/lstrojny/functional-php) repository. The differences are that the functions do not check for whether any of the values are correct and will fail if the collection passed is not an array or traversal. You will get a notice or warning and you will need to fix that in your code.

Validations should happen outside of the function and the functions in this library assume that you are passing correct values as arguments.

The other change is that the code in this library reuses existing functions as much as possible. The goal is function composition and reducing duplicated code. The best way to do that is to reuse as much code as possible, even if it will have less performance.

### Laravel Array Helpers

Some of the functions from Laravel repository have been ported to this library. The names will be different and are under the same namespace as the rest of the library.

There are going to be differences. I'm going off of the documentation web site and not the PHP code. The behavior won't match exactly, but based on the documentation, should at least provide similar behavior.

The Laravel test suite for the Laravel helpers might be pulled and copied to this library to provide a match, but I don't really think it matters that much to completely match Laravel's function. If you are using Laravel, then you will be using Laravel's functions. This library is for those that don't want to pull the Laravel library, but still want to use similar functions.

**Functions that mutate the collection along with returning data will not be ported.** The functions contained in the library may mutate or access data, but not both at the same time. The functions will also return a copy of the collection with the mutation. The original collection must never be mutated by calling any of the below functions.

### Underscore PHP

To further extend the library [Underscore PHP](http://anahkiasen.github.io/underscore-php) was used as a reference. Some of the function names are different since some of the functionality matches that of functional PHP and Laravel array Helpers.

# Guide Table of Contents

**TODO: Need to move this to either docs directory or to the web site for documentation.**

 * [Collection Callback Functions](#collection-callback-functions)
   * [Contains Function](#contains-function)
   * [Each Function](#each-function)
   * [Every Function](#every-function)
   * [False Function](#false-function)
   * [Falsy Function](#falsy-function)
   * [First Index Of Function](#first-index-of-function)
   * [Flat Map Function](#flat-map-function)
   * [Flatten Dot Function](#flatten-dot-function)
   * [Flatten Recursive Function](#flatten-recursive-function)
   * [Flatten Single Function](#flatten-single-function)
   * [Forget Function](#forget-function)
   * [Forget First Function](#forget-first-function)
   * [Forget Last Function](#forget-last-function)
   * [Get Function](#get-function)
   * [Has Function](#has-function)
   * [Indexes Of Function](#indexes-of-function)
   * [Invoke Function](#invoke-function)
   * [Invoke If Function](#invoke-if-function)
   * [Invoke First Function](#invoke-first-function)
   * [Invoke Last Function](#invoke-last-function)
   * [Last Index Of Function](#last-index-of-function)
   * [Map Function](#map-function)
   * [None Function](#none-function)
   * [Pick Function](#pick-function)
   * [Pluck Function](#pluck-function)
   * [Put Function](#put-function)
   * [Reduce Function](#reduce-function)
   * [Reduce Left Function](#reduce-left-function)
   * [Reduce Right Function](#reduce-right-function)
   * [Reject Function](#reject-function)
   * [Select Function](#select-function)
   * [Set Function](#set-function)
   * [Short Function](#short-function)
   * [Size Function](#size-function)
   * [Some Function](#some-function)
   * [Sort Function](#sort-function)
   * [True Function](#true-function)
   * [Truthy Function](#truthy-function)
   * [Zip Function](#zip-function)
 * [Collection Transformation Functions](#collection-transformation-functions)
   * [Clean Function](#clean-function)
   * [Divide Function](#divide-function)
   * [Drop First Function](#drop-first-function)
   * [Drop Last Function](#drop-last-function)
   * [Except Function](#except-function)
   * [Filter Function](#filter-function)
   * [First Function](#first-and-head-function)
   * [Group Function](#group-function)
   * [Head Function](#first-and-head-function)
   * [Initial Function](#initial-function)
   * [Last Function](#last-function)
   * [Only Function](#only-function)
   * [Partition Function](#partition-function)
   * [Rest Function](#rest-function)
   * [Tail Function](#tail-function)
   * [Unique Function](#unique-function)
   * [Without Function](#without-function)
 * [Composition Functions](#composition-functions)
   * [Apply Function](#apply-function)
   * [Attempt Function](#attempt-function)
   * [Compose Function](#compose-function)
   * [Either Function](#either-function)
   * [Execute Function](#execute-function)
   * [Implementation Function](#implementation-function)
   * [Invoke Function](#invoke-function)
   * [Invoke First Function](#invoke-first-function)
   * [Invoke If Function](#invoke-if-function)
   * [Invoke Last Function](#invoke-last-function)
   * [Memorize Function](#memorize-function)
   * [Negate Function](#negate-function)
   * [Partial Any Function](#partial-any-function)
   * [Partial Left Function](#partial-left-function)
   * [Partial Method Function](#partial-method-function)
   * [Partial Right Function](#partial-right-function)
   * [Pipeline Function](#pipeline-function)
   * [Value Function](#value-function)
   * [With Function](#with-function)
 * [Helper Functions](#helper-functions)
   * [Compare Function](#compare-function)
   * [Hash Array Function](#hash-array-function)
   * [Pass Original Collection Function](#pass-original-collection-function)
   * [Sortable Function](#sortable-function)
 * [Mathematics Callback Functions](#mathematics-functions)
   * [Average Function](#average-function)
   * [Difference Function](#difference-function)
   * [Maximum Function](#maximum-function)
   * [Minimum Function](#minimum-function)
   * [Product Function](#product-function)
   * [Quotient and Quotient Divisor Function](#quotient-function)
   * [Sum Function](#sum-function)

# Collection Callback Functions

Most collection callback will have the element, index and collection passed as arguments.

```php
$callback = function($element, $index, $collection) {
	// return after doing something.
};
```

Reduce collection callback will have an additional argument of the current value.

```php
$callback = function($element, $current, $index, $collection) {
	// return something with element and current.
};
```

It is not required to have each parameter and it is recommend to only have the parameters.

## Drop First Function

Drop elements in collection until callback returns false. This will remove elements from the initial part of the array.

```php
$values = array(0, 1, 2, 3, 4);

$filtered = \Mimic\Functional\dropFirst($values, function($element) {
	return $element < 2;
});
```

`$filtered` would be `array(2, 3, 4)`.

If the array is not sorted, then the above will not give the desired results.

```php
$values = array(2, 0, 1, 3, 4);

$filtered = \Mimic\Functional\dropFirst($values, function($element) {
	return $element < 2;
});
```

`$filtered` would be `array(2, 0, 1, 3, 4)`.

## Drop Last Function

Drop elements in collection after callback returns true. This will remove elements from the rest of the array.

```php
$values = array(0, 1, 2, 3, 4);

$filtered = \Mimic\Functional\dropFirst($values, function($element) {
	return $element >= 3;
});
```

`$filtered` would be `array(0, 1, 2)`.

## Each Function

Each iterates through each element passing to a callback, but nothing is saved and nothing is returned when iteration is completed.

```php
$values = array(0, 1, 2, 3, 4);

\Mimic\Functional\each($values, function($element) {
	echo $element * $element;
});

// Output: 014916
```

## Every Function

Iterates through a collection checking that every element pass the callback. This is the opposite of [none()](#none-function).

```php
$callback = function($element) {
	return $element === 1;
};

$true = \Mimic\Functional\every(array(1, 1, 1, 1), $callback);
$false = \Mimic\Functional\every(array(1, 2, 1, 1), $callback);
```

## Filter Function

Accepts elements in a collection, when the callback returns true or discards elements when the callback returns false. Opposite of [reject()](#reject-function). The [select()](#select-function) function exists as an alias for semantics.

```php
/** @todo finish example(s) */
```

## First and Head Function

Retrieves the first element in a collection, if there is no callback.

```php
$collection = array(1, 1, 4, 2, 3, 4, 5);

$result = \Mimic\Functional\first($collection);
// $result = 1;
// $index = 0;

$result = \Mimic\Functional\head($collection);
// $result = 1;
// $index = 0;
```

When there is a callback, then that callback is applied and the first element that the callback returns true for is returned.

```php
$collection = array(1, 1, 4, 2, 3, 4, 5);

$callback = function($element, $index, $collection) {
	return $element === 4;
};

$result = \Mimic\Functional\first($collection, callback);
// $result = 4;
// $index = 2;

$result = \Mimic\Functional\head($collection, callback);
// $result = 4;
// $index = 2;
```

## First Index Of Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Flat Map Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Flatten Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Group Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Invoke Function

Invoke method on class, if the method exists on the class. This can be used for both instance and class methods. It is possible to use this for objects that are mixed and the execution will skip elements that aren't objects or when the element is combined with the method name parameter is not callable.

The arguments are passed as an array to allow for better composition. This is largely a PHP5.3 limitation. PHP7 or PHP5.6 solutions probably won't require this in the future.

```php
class Example {
	public method test() {
		return func_get_args();
	}

	public static method testStatic() {
		return func_get_args();
	}
}

$instance = new Example;

$collection = array('nothing', $instance, $instance, 'Example', 'Example');

$result = \Mimic\Functional\invoke($collection, 'test');
// $result = array(
//     null,
//     array(),
//     array(),
//     null,
//     null,
// );

$result = \Mimic\Functional\invoke($collection, 'test', array(1));
// $result = array(
//     null,
//     array(1),
//     array(1),
//     null,
//     null,
// );

$result = \Mimic\Functional\invoke($collection, 'testStatic');
// $result = array(
//     null,
//     null,
//     null,
//     array(),
//     array(),
// );

$result = \Mimic\Functional\invoke($collection, 'testStatic', array(1));
// $result = array(
//     null,
//     null,
//     null,
//     array(1),
//     array(1),
// );
```

## Invoke If Function

Invoke method on class, only if the result is callable. You can set the default value that will be returned when the given arguments are not callable. The arguments that are passed to the callback are contained in an array.

```php
class Example {
	public method test() {
		return func_get_args();
	}

	public static method testStatic() {
		return func_get_args();
	}
}

$instance = new Example;

$result = \Mimic\Functional\invokeIf($instance, 'test');
// $result = array();

$result = \Mimic\Functional\invokeIf($instance, 'test', array(1));
// $result = array(1);

$result = \Mimic\Functional\invokeIf($instance, 'denied', array(1));
// $result = null;

$result = \Mimic\Functional\invokeIf($instance, 'denied', array(1), false);
// $result = false;

$result = \Mimic\Functional\invokeIf('Example', 'testStatic');
// $result = array();

$result = \Mimic\Functional\invokeIf('Example', 'testStatic', array(1));
// $result = array(1);

$result = \Mimic\Functional\invokeIf('Example', 'denied', array(1));
// $result = null;

$result = \Mimic\Functional\invokeIf('Example', 'denied', array(1), false);
// $result = false;
```

## Invoke First Function

Invoke the first element that is callable and return the result from this callback.

```php
class Example1 {
	public method test() {
		return func_get_args();
	}

	public static method testStatic() {
		return func_get_args();
	}
}

class Example2 {
	public method test() {
		return array('example2->test()');
	}

	public static method testStatic() {
		return array('example2::testStatic');
	}
}

$collection = array('nothing', new Example1, new Example2, 'Example1', 'Example2');

$result = \Mimic\Functional\invokeFirst($collection, 'test');
// $result = \Mimic\Functional\value(new Example1)->test();
// $result = array();

$result = \Mimic\Functional\invokeFirst($collection, 'test', array(1));
// $result = \Mimic\Functional\value(new Example1)->test(1);
// $result = array(1);

$result = \Mimic\Functional\invokeFirst($collection, 'testStatic'));
// $result = Example1::testStatic();
// $result = array();

$result = \Mimic\Functional\invokeFirst($collection, 'testStatic', array(1));
// $result = Example1::testStatic(1);
// $result = array(1);
```

## Invoke Last Function

Invoke the last element that is callable and return the result from this callback.

```php
class Example1 {
	public method test() {
		return func_get_args();
	}

	public static method testStatic() {
		return func_get_args();
	}
}

class Example2 {
	public method test() {
		return array('example2->test()');
	}

	public static method testStatic() {
		return array('example2::testStatic');
	}
}

$collection = array('nothing', new Example1, new Example2, 'Example1', 'Example2');

$result = \Mimic\Functional\invokeFirst($collection, 'test');
// $result = \Mimic\Functional\value(new Example2)->test();
// $result = array('example2->test()');

$result = \Mimic\Functional\invokeFirst($collection, 'test', array(1));
// $result = \Mimic\Functional\value(new Example2)->test(1);
// $result = array('example2->test()');

$result = \Mimic\Functional\invokeFirst($collection, 'testStatic'));
// $result = Example2::testStatic();
// $result = array('example2::testStatic');

$result = \Mimic\Functional\invokeFirst($collection, 'testStatic', array(1));
// $result = Example2::testStatic(1);
// $result = array('example2::testStatic');
```

## Last and Tail Function

Retrieve the last element of a collection, when there are no callback given.

```php
$collection = array(1, 1, 4, 2, 3, 4, 5);

$result = \Mimic\Functional\last($collection);
// $result = 5;
// $index = 6;

$result = \Mimic\Functional\tail($collection);
// $result = 5;
// $index = 6;
```

If there is a callback passed, then it will return the last element that the callback returns true.

```php
$collection = array(1, 1, 4, 2, 3, 4, 5);

$callback = function($element, $index, $collection) {
	return $element === 4;
};

$result = \Mimic\Functional\last($collection, callback);
// $result = 4;
// $index = 5;

$result = \Mimic\Functional\tail($collection, callback);
// $result = 4;
// $index = 5;
```

## Last Index Of Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Map Function

Map iterates through each element applying callback to each. The return value is saved and returned in an array.

```php
$values = array(0, 1, 2, 3, 4);

$squares = \Mimic\Functional\map($values, function($element) {
	return $element * $element;
});
```

`$squares` will contain `array(0, 1, 4, 9, 16)`.

## None Function

Iterates through a collection checking that none of the elements pass the callback. This is the opposite of [every()](#every-function).

```php
$callback = function($element) {
	return $element === 1;
};

$true = \Mimic\Functional\none(array(2, 2, 2, 2), $callback);
$false = \Mimic\Functional\none(array(1, 2, 2, 2), $callback);
```

## Partition Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Pick Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Pluck Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Reduce Function

Iterates through a collection returning a single value after processing all of the elements. The initial value must also be passed as the second argument.

```php
$values = array(0, 1, 2, 3, 4);

$sum = \Mimic\Functional\reduce($values, 0, function($element, $current) {
	return $current + $element;
});
```

`$sum` will be 10.

```php
$values = array(0, 1, 2, 3, 4);

$sum = \Mimic\Functional\reduce($values, 5, function($element, $current) {
	return $current + $element;
});
```

`$sum` will be 15.

## Reduce Left Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Reduce Right Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Reject Function

This rejects or discards elements when the callback returns true. Opposite of [filter()](#filter-function) and [select()](#select-function).

```php
/** @todo finish example(s) */
```

## Select Function

Alias for [filter()](#filter-function). This function works the same as [filter()](#filter-function). This exists to be the opposite of [reject()](#reject-function) in semantics. So if you wish to select on a collection instead of filter the collection, then you may use this function to do so. That way when reading the code, rejecting and selecting are semantically describe the process on a collection.

```php
/** @todo finish example(s) */
```

## Short Function

Short will check the callback and break out of the collection once the callback returns true. This is useful, when you need to escape out of the collection after a condition is met.

You should also see `dropFirst()` and `dropLast()` for removing elements from a collection.

```php
$values = array(0, 1, 2, 3, 4);
$checkValue = 5;

$contains = \Mimic\Functional\reduce($values, true, false, function($element) use ($checkValue) {
	return $element === $checkValue;
});
```

`$contains` is false.

```php
$values = array(0, 1, 2, 3, 4);
$checkValue = 2;

$contains = \Mimic\Functional\reduce($values, true, false, function($element) use ($checkValue) {
	return $element === $checkValue;
});
```

`$contains` is true.

## Some Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Sort Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Unique Function


TODO: Complete

```php
/** @todo finish example(s) */
```


## Zip Function


TODO: Complete

```php
/** @todo finish example(s) */
```


# Helper Functions

Helper functions don't take a callback and provide a simple way to iterate through a collection performing a specialized task and return the result.

## Compare Function

Creates a callback to be used in collection functions that compares the collection element to the compare value. Optionally testing whether the type also matches.

```php
$value = 1;
$checkTypeMatches = true;
$callback = \Mimic\Functional\compare($value, $checkTypeMatches);

$false = $callback(0);
$false = $callback('0');

$true = $callback(1);
```

If you don't have a strict check, then it will simply compare two values.

```php
$value = 1;
$checkTypeMatches = false;
$callback = \Mimic\Functional\compare($value, $checkTypeMatches);

$false = $callback(0);

$true = $callback(1);
$true = $callback('1');
```

## Contains Function

Contains looks for whether the given value exists in the collection.

```php
$values = array('something', 'else', 'here');
$exists = \Mimic\Functional\contains($values, 'else');

if ($exists) {
	echo "Else exists in values.";
}

$exists = \Mimic\Functional\contains($values, 'hello');

if ( ! $exists ) {
	echo "Hello does not exist in values.";
}
```

You may also use a strict check to ensure that the type matches.

```php
$values = array(1, 3, '5');
$exists = \Mimic\Functional\contains($values, 3, true);

if ($exists) {
	echo "3 exists in values.";
}

$exists = \Mimic\Functional\contains($values, 5, true);

if ( ! $exists ) {
	echo "5 integer does not exists in values.";
}
```

## False Function

False function checks that every value in the array is false. This is useful in combination with map where you evaluate some clause and then use this function for whether every value is identical to false.

```php
$values = array(1, 3, 5, 7);
$evenEvaluation = \Mimic\Functional\map($values, function($element) {
	return ($element % 2) === 0;
});

$allOdd = \Mimic\Functional\false($evenEvaluation);

if ($allOdd) {
	echo "All values are odd.";
}
```

## Falsy Function

Falsy function checks that every value in the array evaluates to false. Please note that certain values that aren't false, will still evaluate to false.

```php
$values = array(false, 0, '', null);
$allFalsy = \Mimic\Functional\falsy($values);

if ($allFalsy) {
	echo "All values are falsy.";
}
```

## Memoize Function

[Memorization](https://en.wikipedia.org/wiki/Memoization) is the process of storing or saving the results of the function call. This caching allows for very quickly returning results that may take a while to process. This should only be used for pure functions or functions that will always return the same output for the given inputs. Doing this for functions that don't have this behavior will fail.

The closure that is returned by the memoize function has the same definition of the callback that is passed to the function. It simply wraps the callback with the behavior of storing the results and returning the original result value. Given the hashing process, this should only be used when there is still a performance gain even with the hashing. This should be simple to compare. Run performance benchmarks without memoize and run them with memoize. If it is faster to use memoize, then use it. Be aware that additional memory will be consumed with every call that uses different arguments.


```php
$memoizedCallback = \Mimic\Functional\memoize(function($name) {
	echo "Function called!\n";
	return 'hello '. $name;
});

$result = $memoizedCallback('Jacob');

// Output: Function called!
// $result = 'hello Jacob';

// Second call
$result = $memoizedCallback('Jacob');

// Output: (No output from call)
// $result = 'hello Jacob';
```

It is also possible to clear all of the results by calling `clear() on the returned object.

```php
$memoizedCallback = \Mimic\Functional\memoize(function($name) {
	echo "Function called!";
	return 'hello '. $name;
});

$result = $memoizedCallback('Jacob');

// Output: Function called!
// $result = 'hello Jacob';

$memoizedCallback->clear();

$result = $memoizedCallback('Jacob');

// Output: Function called!
// $result = 'hello Jacob';
```

Finally, it is possible to clear the result of a single value by passing the original argument to the `clean` method.

```php
$memoizedCallback = \Mimic\Functional\memoize(function($name) {
	echo "Function called!";
	return 'hello '. $name;
});

$result = $memoizedCallback('Jacob');

// Output: Function called!
// $result = 'hello Jacob';

$memoizedCallback->clean('Jacob');

$result = $memoizedCallback('Jacob');

// Output: Function called!
// $result = 'hello Jacob';
```

The result of the call when there are no arguments will also be cached. You may also clean the result of invocation without any arguments by calling `$memoizedCallback->clean();` or calling `clean` method, also without any arguments.

**Warning:** At the moment, memorized can not be passed to other functions in the library. This will be fixed before release.

## Negate Function

Negates any boolean value that is given to the callback. The function is meant to be passed as collection callback functions.

```php
$callback = function($element) {
	return true;
}

$negate = \Mimic\Functional\negate($callback);

if ( ! $negate(1, null, null) ) {
	echo "You shall not pass!"
}
```

## True Function

True function checks that every value in the array is true. This is useful in combination with map where you evaluate some clause and then use this function for whether every value is identical to true.

```php
$values = array(2, 4, 6, 8);
$evenEvaluation = \Mimic\Functional\map($values, function($element) {
	return ($element % 2) === 0;
});

$allEven = \Mimic\Functional\true($evenEvaluation);

if ($allEven) {
	echo "All values are even.";
}
```

## Truthy Function

Truthy function checks that every value in the array evaluates to true. Please note that certain values that aren't true, will still evaluate to true.

```php
$values = array(true, 1, -1, '0', array());
$allTruthy = \Mimic\Functional\truthy($values);

if ($allTruthy) {
	echo "All values are truthy.";
}
```

## Value Function

Value returns the given value, unless a callback is given to value, then the result from the callback called with no arguments will be returned.

```php
$zero = \Mimic\Functional\value(0);
$true = \Mimic\Functional\value(true);
$true = \Mimic\Functional\value(function() { return true; });
```

The value function will work with objects. Please be aware that this shortcut does not need to be used with PHP5.4 and later.

```php
$object = \Mimic\Functional\value(new Type());
```

## With Function

With function passes the given value to the callback and returns the result of the callback.

```php
$callback = function($value) {
	return ! $value;
};
$false = \Mimic\Functional\with(true, $callback);

$true = \Mimic\Functional\with(false, $callback);
```

# Mathematics Functions

Functions which take a collection and apply some process to the collection. These functions don't take a callback and are helpers for common math operations for collections containing integers and floats.

The functions will work with numeric strings, integers and floats. You could also combine the types in the collection.

## Average Function

Average returns the average using basic PHP operations. This function does not use `GMP` or `bcmath` extensions. If you need more accurate results, then you will need to use another function.

```php
$average = \Mimic\Functional\average(array(0, 1, 2, 3, 4));
```

`$average` will be `2`.

```php
$average = \Mimic\Functional\average(array(1.5, 2.5, 2.5, 2.5, 3.5, 4.5));
```

`$average` will be `2.83333`.

## Difference Function

Difference returns the total of values subtracted from the initial value. The default value is `0` and is optional.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5));
```

`$total` will be `-15`.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5), 15);
```

`$total` will be `0`.

## Maximum Function

Return the maximum numeric value in a collection.

```php
$max = \Mimic\Functional\maximum(array(1, 2, 3, 4, 5));
```

`$max` will be 5.

## Minimum Function

Return the maximum numeric value in a collection.

```php
$min = \Mimic\Functional\minimum(array(1, 2, 3, 4, 5));
```

`$min` will be 1.

## Product Function

Product returns the total of values multiplied by the initial value. The default value is `1` and is optional. Passing `0` (zero) will do nothing and the function will not escape when the initial value is zero causing a delay.

```php
$total = \Mimic\Functional\product(array(1, 2, 3, 4, 5));
```

`$total` will be `120`.

```php
$total = \Mimic\Functional\product(array(1, 2, 3, 4, 5), 5);
```

`$total` will be `600`.

```php
$total = \Mimic\Functional\product(array(1, 2, 3, 0, 4, 5), 1);
$total = \Mimic\Functional\product(array(1, 2, 3, 4, 5, 0), 1);
```

`$total` will be `0` for both calls. Any `0` value will break the final value and it will always be zero. Do a filter to remove `0` values.

## Quotient Functions

Quotient returns the total of values divided by the initial value. The default value is `1` and is optional. Passing `0` (zero) will do nothing and the function will not escape when the initial value is zero causing a delay.

```php
$total = \Mimic\Functional\quotientDivisor(array(5, 10, 100));
```

`$total` will be `50`. The execution will be `5 / 1`, `10 / 5` and finally `100 / 2` for `50`.

```php
$total = \Mimic\Functional\quotientDivisor(array(2, 4, 10));
```

`$total` will be `5`. The execution will be `2 / 1`, `4 / 2`, and finally `10 / 2` for `5`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3), 5);
```

`$total` will be `0.3`. The execution will be `1 / 5`, `2 / 0.2` and finally `3 / 10` for `0.3`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 0, 4, 5), 1);
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 4, 5, 0), 1);
```

`$total` will be `0` for both calls. Any `0` value will break the final value and it will always be zero. Do a filter to remove `0` values.

The `quotient()` function is more like how language handles operator precedence. These two functions exist for the purposes of which one is how you want to handle the division. The initial value is by default, not used.

```php
$total = \Mimic\Functional\quotient(array(100, 10, 5));
```

`$total` will be `2`. The execution will be `100 / 10 / 5` which is `2`.

```php
$total = \Mimic\Functional\quotient(array(10, 5), 100);
```

`$total` will be `2`. The execution will be `100 / 10 / 5` which is `2`.

```php
$total = \Mimic\Functional\quotient(array(1, 2, 3, 0, 4, 5), 100);
$total = \Mimic\Functional\quotient(array(1, 2, 3, 4, 5, 0), 100);
```

The `0` values will be ignored or filtered from the evaluation. So the execution will be `100 / 1 / 2 / 3 / 4 / 5`, which is `0.83333333`.

## Sum Function

Sum returns the total of values added from the initial value. The default value is `0` and is optional.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5));
```

`$total` will be `15`.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5), 15);
```

`$total` will be `30`.
