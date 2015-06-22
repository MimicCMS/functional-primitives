<?php
/**
 * @package Mimic\Functional
 * @since 0.1.0
 * @license MIT
 *
 * @typedef Number int|float
 */

/** @package Mimic\Functional */
namespace Mimic\Functional;

/**
 * Average of all numeric elements in a collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @return Number
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

	return $amount / $total;
}

/**
 * Difference of all numeric elements in a collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @return Number
 */
function difference($collection, $initial = 0) {
	return reduceNumber($collection, $initial, function($element, $current) {
		return $current - $element;
	});
}

/**
 * Maximum numeric value from collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @return Number|null
 *   Will return null, if none of the elements are numeric.
 */
function maximum($collection) {
	return reduceNumber($collection, null, function($element, $current) {
		return $element > $current ? $element : $current;
	});
}

/**
 * Minimum numeric value from collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @return Number|null
 *   Will return null, if none of the elements are numeric.
 */
function minimum($collection) {
	return reduceNumber($collection, null, function($element, $current) {
		return $element < $current ? $element : $current;
	});
}

/**
 * Product of all numeric elements in a collection.
 *
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @param Number $initial
 * @return Number
 */
function product($collection, $initial = 1) {
	return reduceNumber($collection, $initial, function($element, $current) {
		return $current * $element;
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
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @param Number $initial
 *
 * @return Number
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
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @param Number|null $initial
 *
 * @return Number|null
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
 * @api
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @param Number $initial
 * @return Number
 */
function sum($collection, $initial = 0) {
	return reduceNumber($collection, $initial, function($element, $current) {
		return $current + $element;
	});
}

/**
 * Reduce numeric values in a collection.
 *
 * @since 0.1.0
 *
 * @param array<Number>|\Traversable<Number> $collection
 * @param Number|null $initial
 * @param \Closure $callback {
 *     @param Number $element
 *     @param Number|null $current
 * }
 * @return Number|null
 */
function reduceNumber($collection, $initial, \Closure $callback) {
	return reduce($collection, $initial, collectionNumberOperation($callback));
}

/**
 * Check whether element is numeric applying callback or return current value.
 *
 * @since 0.1.0
 *
 * @param \Closure $callback {
 *     @param Number $element
 *     @param Number|null $current
 * }
 * @return Number|null
 */
function collectionNumberOperation(\Closure $callback) {
	return function($element, $current) use ($callback) {
		if ( is_numeric($element) ) {
			return $callback($element, $current);
		}
		return $current;
	};
}
