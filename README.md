# Mimic Function Primitives

[![Code Climate](https://codeclimate.com/github/MimicCMS/functional-primitives.png)](https://codeclimate.com/github/MimicCMS/functional-primitives)
[![Test Coverage](https://codeclimate.com/github/MimicCMS/functional-primitives/coverage.png)](https://codeclimate.com/github/MimicCMS/functional-primitives)
[![Build Status](https://travis-ci.org/MimicCMS/functional-primitives.svg?branch=master)](https://travis-ci.org/MimicCMS/functional-primitives)

Function primitives form a base of function composition allowing for reusable
components.

Library supports PHP5.3. Other versions of PHP are supported allowing for
features in other versions.

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

# Helper Functions

Helper functions don't take a callback and provide a simple way to iterate
through a collection performing a specialized task and return the result.

## Contains Function

## False Function

## Falsy Function

## True Function

## Truthy Function


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

## Each

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

## Reduce

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

## Short

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

## With Function

## Zip Function

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

## Quotient Function

Quotient returns the total of values divided by the initial value. The default
value is `1` and is optional. Passing `0` (zero) will do nothing and the
function will not escape when the initial value is zero causing a delay.

```php
$total = \Mimic\Functional\quotientDivisor(array(5, 10, 100));
```

`$total` will be `50`. So the result will be `5 / 1`, `10 / 5` and finally
`100 / 2` for `50`.

```php
$total = \Mimic\Functional\quotientDivisor(array(2, 4, 10));
```

`$total` will be `5`. The execution will be `2 / 1`, `4 / 2`, and finally
`10 / 2` for `5`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 4, 5), 5);
```

`$total` will be `600`.

```php
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 0, 4, 5), 1);
$total = \Mimic\Functional\quotientDivisor(array(1, 2, 3, 4, 5, 0), 1);
```

`$total` will be `0` for both calls. Any `0` value will break the final value
and it will always be zero. Do a filter to remove `0` values.

## Sum Function