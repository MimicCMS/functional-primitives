<?php
/**
 * @package Mimic\Functional
 * @since 0.1.0
 * @license MIT
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

/**
 * Average of all numeric elements in a collection.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @return int
 */
function average($collection) {
	$amount = 0;
	$total = 0;

	each($collection, function($element) use (&$amount, &$total) {
		if ( is_numeric($element) ) {
			$amount += (int) $element;
			$total += 1;
		}
	});

	if ($total < 1) {
		return 0;
	}

	return $total / $amount;
}

/**
 * Difference of all numeric elements in a collection.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @return int
 */
function difference($collection, $initial = 0) {
	return reduce($collection, $initial, function($element, $current) {
		if ( is_numeric($element) ) {
			return $current - $element;
		}
		return $current;
	});
}

/**
 * Maximum numeric value from collection.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @return int|float|null
 *   Will return null, if none of the elements are numeric.
 */
function maximum($collection) {
	return reduce($collection, null, function($element, $current) {
		if ( is_numeric($element) ) {
			return $element > $current ? $element : $current;
		}
		return $current;
	});
}

/**
 * Minimum numeric value from collection.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @return int|float|null
 *   Will return null, if none of the elements are numeric.
 */
function minimum($collection) {
	return reduce($collection, null, function($element, $current) {
		if ( is_numeric($element) ) {
			return $element < $current ? $element : $current;
		}
		return $current;
	});
}

/**
 * Product of all numeric elements in a collection.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @param int|float $initial
 * @return int|float
 */
function product($collection, $initial = 1) {
	return reduce($collection, $initial, function($element, $current) {
		if ( is_numeric($element) ) {
			return $current * $element;
		}
		return $current;
	});
}

/**
 * Quotient of all numeric elements in a collection.
 *
 * This has the initial value and the result of the previous division operation
 * as the divisor. For a collection, `1, 2, 3`, the operation would be `1 / 1`,
 * `2 / 1`, `3 / 2`. That may not be the most clear. Take another collection,
 * `3, 6, 8`, where the default operation will be `3 / 1`, `6 / 3`, `8 / 2`.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @param int|float $initial
 *
 * @return int|float
 */
function quotientDivisor($collection, $initial = 1) {
	return reduce($collection, $initial, function($element, $divisor) {
		// Do not allow elements that are zero to be divided to prevent divid
		// by zero exceptions.
		// This may prevent 0.nnnnnn numbers.
		if ($divisor == 0) {
			return $element;
		}
		if ( is_numeric($element) ) {
			return $element / $divisor;
		}
		return $divisor;
	});
}

/**
 * Quotient of all numeric elements in a collection.
 *
 * Each element is the divisor of the current quotient of the previous
 * division operation. For a collection of `1, 2, 3`, the operation will be
 * `1 / 2 / 3`, which is how normal division operation works in programming
 * languages. {@link \Mimic\Functional\quotientDivisor} has the opposite, where
 * the quotient is the divisor.
 *
 * @param \Traversable<int|float>|array<int|float> $collection
 * @param int|float|null $initial
 *
 * @return int|float|null
 */
function quotient($collection, $initial = null) {
	return reduce($collection, $initial, function($element, $current) {
		// Do not allow elements that are zero to be divided to prevent divid
		// by zero exceptions.
		// This may prevent 0.nnnnnn numbers.
		if ($element == 0) {
			return $current;
		}
		if ($current === null && is_numeric($element)) {
			return $element;
		}
		if ( is_numeric($element) ) {
			return $current / $element;
		}
		return $current;
	});
}

/**
 * Sum all numeric values in collection.
 *
 * @param \Traversable|array $collection
 * @param int|float $initial
 * @return int|float
 */
function sum($collection, $initial = 0) {
	return reduce($collection, $initial, function($element, $current) {
		if ( is_numeric($element) ) {
			return $current + $element;
		}
		return $current;
	});
}
