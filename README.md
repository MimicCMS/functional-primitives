# Mimic Function Primitives

[![Code Climate](https://codeclimate.com/github/MimicCMS/functional-primitives.png)](https://codeclimate.com/github/MimicCMS/functional-primitives)
[![Test Coverage](https://codeclimate.com/github/MimicCMS/functional-primitives/coverage.png)](https://codeclimate.com/github/MimicCMS/functional-primitives)
[![Build Status](https://travis-ci.org/MimicCMS/functional-primitives.svg?branch=master)](https://travis-ci.org/MimicCMS/functional-primitives)

Function primitives form a base of function composition allowing for reusable
components.

Library supports PHP5.3. Other versions of PHP are supported allowing for
features in other versions.

## Installation

You may install this library using composer.

**TODO: Need to add composer configuration.**

## Inspirations

### Functional PHP Library

This library is inspired by Lars Strojny
[Functional PHP](https://github.com/lstrojny/functional-php) repository. The
differences are that the functions do not check for whether any of the values
are correct and will fail if the collection passed is not an array or traversal.
You will get a notice or warning and you will need to fix that in your code.

Validations should happen outside of the function and the functions in this
library assume that you are passing correct values as arguments.

The other change is that the code in this library reuses existing functions as
much as possible. The goal is function composition and reducing duplicated code.
The best way to do that is to reuse as much code as possible, even if it will
have less performance.

### Laravel Helpers

Some of the functions from Laravel repository have been ported to this library.
The names will be different and are under the same namespace as the rest of the
library.

There are going to be differences. I'm going off of the documentation web site
and not the PHP code. The behavior won't match exactly, but based on the
documentation, should at least provide similar behavior.

The Laravel test suite for the Laravel helpers might be pulled and copied to
this library to provide a match, but I don't really think it matters that much
to completely match Laravel's function. If you are using Laravel, then you will
be using Laravel's functions. This library is for those that don't want to pull
the Laravel library, but still want to use similar functions.

# Guide Table of Contents

 * [Collection Callback Functions](#helper-functions)
   * [Drop First Function](#drop-first-function)
   * [Drop Last Function](#drop-last-function)
   * [Each Function](#each-function)
   * [Filter Function](#filter-function)
   * [First Function](#first-function)
   * [First Index Of Function](#first-index-of-function)
   * [Flat Map Function](#flat-map-function)
   * [Flatten Function](#flatten-function)
   * [Group Function](#group-function)
   * [Head Function](#head-function)
   * [Invoke Function](#invoke-function)
   * [Invoke First Function](#invoke-first-function)
   * [Invoke Last Function](#invoke-last-function)
   * [Last Function](#last-function)
   * [Last Index Of Function](#last-index-of-function)
   * [Map Function](#map-function)
   * [Memoize Function](#memorize-function)
   * [None Function](#none-function)
   * [Partition Function](#partition-function)
   * [Pick Function](#pick-function)
   * [Pluck Function](#pluck-function)
   * [Reduce Function](#reduce-function)
   * [Reduce Left Function](#reduce-left-function)
   * [Reduce Right Function](#reduce-right-function)
   * [Reject Function](#reject-function)
   * [Select Function](#select-function)
   * [Short Function](#short-function)
   * [Some Function](#some-function)
   * [Sort Function](#sort-function)
   * [Tail Function](#tail-function)
   * [Unique Function](#unique-function)
   * [Zip Function](#zip-function)
 * [Helper Functions](#helper-functions)
   * [Contains Function](#contains-function)
   * [False Function](#false-function)
   * [Falsy Function](#falsy-function)
   * [True Function](#true-function)
   * [Truthy Function](#truthy-function)
   * [Value Function](#value-function)
   * [With Function](#with-function)
 * [Mathematics Callback Functions](#mathematics-functions)
   * [Average Function](#average-function)
   * [Difference Function](#difference-function)
   * [Maximum Function](#maximum-function)
   * [Minimum Function](#minimum-function)
   * [Product Function](#product-function)
   * [Quotient Function](#quotient-function)
   * [Sum Function](#sum-function)

# Collection Callback Functions

Most collection callback will have the element, index and collection passed as
arguments.

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

It is not required to have each parameter and it is recommend to only have the
parameters.

## Drop First Function

## Drop Last Function

## Each Function

Each iterates through each element passing to a callback, but nothing is saved
and nothing is returned when iteration is completed.

```php
$values = array(0, 1, 2, 3, 4);

\Mimic\Functional\each($values, function($element) {
	echo $element * $element;
});

// Output: 014916
```

## Filter Function

## First Function

## First Index Of Function

## Flat Map Function

## Flatten Function

## Group Function

## Head Function

## Invoke Function

## Invoke First Function

## Invoke Last Function

## Last Function

## Last Index Of Function

## Map Function

Map iterates through each element applying callback to each. The return value is
saved and returned in an array.

```php
$values = array(0, 1, 2, 3, 4);

$squares = \Mimic\Functional\map($values, function($element) {
	return $element * $element;
});
```

`$squares` will contain `array(0, 1, 4, 9, 16)`.

## Memoize Function

## None Function

## Partition Function

## Pick Function

## Pluck Function

## Reduce Function

Iterates through a collection returning a single value after processing all of
the elements. The initial value must also be passed as the second argument.

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

## Reduce Right Function

## Reject Function

## Select Function

## Short Function

Short will check the callback and break out of the collection once the callback
returns true. This is useful, when you need to escape out of the collection
after a condition is met.

You should also see `dropFirst()` and `dropLast()` for removing elements from a
collection.

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

## Sort Function

## Tail Function

## Unique Function

## Zip Function

# Helper Functions

Helper functions don't take a callback and provide a simple way to iterate
through a collection performing a specialized task and return the result.

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

False function checks that every value in the array is false. This is useful in
combination with map where you evaluate some clause and then use this function
for whether every value is identical to false.

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

Falsy function checks that every value in the array evaluates to false. Please
note that certain values that aren't false, will still evaluate to false.

```php
$values = array(false, 0, '', null);
$allFalsy = \Mimic\Functional\falsy($values);

if ($allFalsy) {
	echo "All values are falsy.";
}
```

## True Function

True function checks that every value in the array is true. This is useful in
combination with map where you evaluate some clause and then use this function
for whether every value is identical to true.

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

Truthy function checks that every value in the array evaluates to true. Please
note that certain values that aren't true, will still evaluate to true.

```php
$values = array(true, 1, -1, '0', array());
$allTruthy = \Mimic\Functional\truthy($values);

if ($allTruthy) {
	echo "All values are truthy.";
}
```

## Value Function

Value returns the given value, unless a callback is given to value, then the
result from the callback called with no arguments will be returned.

```php
$zero = \Mimic\Functional\value(0);
$true = \Mimic\Functional\value(true);
$true = \Mimic\Functional\value(function() { return true; });
```

The value function will work with objects. Please be aware that this shortcut
does not need to be used with PHP5.4 and later.

```php
$object = \Mimic\Functional\value(new Type());
```

## With Function

With function passes the given value to the callback and returns the result of
the callback.

```php
$callback = function($value) {
	return ! $value;
};
$false = \Mimic\Functional\with(true, $callback);

$true = \Mimic\Functional\with(false, $callback);
```

# Mathematics Functions

Functions which take a collection and apply some process to the collection.
These functions don't take a callback and are helpers for common math operations
for collections containing integers and floats.

The functions will work with numeric strings, integers and floats. You could
also combine the types in the collection.

## Average Function

Average returns the average using basic PHP operations. This function does not
use `GMP` or `bcmath` extensions. If you need more accurate results, then you
will need to use another function.

```php
$average = \Mimic\Functional\average(array(0, 1, 2, 3, 4));
```

`$average` will be `2`.

```php
$average = \Mimic\Functional\average(array(1.5, 2.5, 2.5, 2.5, 3.5, 4.5));
```

`$average` will be `2.83333`.

## Difference Function

Difference returns the total of values subtracted from the initial value. The
default value is `0` and is optional.

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

Product returns the total of values multiplied by the initial value. The default
value is `1` and is optional. Passing `0` (zero) will do nothing and the
function will not escape when the initial value is zero causing a delay.

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

`$total` will be `0` for both calls. Any `0` value will break the final value
and it will always be zero. Do a filter to remove `0` values.

## Quotient Functions

Quotient returns the total of values divided by the initial value. The default
value is `1` and is optional. Passing `0` (zero) will do nothing and the
function will not escape when the initial value is zero causing a delay.

```php
$total = \Mimic\Functional\quotientDivisor(array(5, 10, 100));
```

`$total` will be `50`. The execution will be `5 / 1`, `10 / 5` and finally
`100 / 2` for `50`.

```php
$total = \Mimic\Functional\quotientDivisor(array(2, 4, 10));
```

`$total` will be `5`. The execution will be `2 / 1`, `4 / 2`, and finally
`10 / 2` for `5`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3), 5);
```

`$total` will be `0.3`. The execution will be `1 / 5`, `2 / 0.2` and finally
`3 / 10` for `0.3`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 0, 4, 5), 1);
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 4, 5, 0), 1);
```

`$total` will be `0` for both calls. Any `0` value will break the final value
and it will always be zero. Do a filter to remove `0` values.

The `quotient()` function is more like how language handles operator precedence.
These two functions exist for the purposes of which one is how you want to
handle the division. The initial value is by default, not used.

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

The `0` values will be ignored or filtered from the evaluation. So the execution
will be `100 / 1 / 2 / 3 / 4 / 5`, which is `0.83333333`.

## Sum Function

Sum returns the total of values added from the initial value. The
default value is `0` and is optional.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5));
```

`$total` will be `15`.

```php
$total = \Mimic\Functional\difference(array(1, 2, 3, 4, 5), 15);
```

`$total` will be `30`.
