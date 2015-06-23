<?php

use Mimic\Functional as F;

/**
 * Unit Test for quotient Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class QuotientFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(null,  0.0083333333333333332, array(1, 2, 3, 4, 5)),
			array(null, -0.0083333333333333332, array(-1, -2, -3, -4, -5)),
			array(null, -0.0083333333333333332, array(-1, -2, -3, -4, -5, 0)),
			array(null,  0.0069264069264069273, array(1.5, 2.5, 3.5, 4.5, 5.5)),
			array(null, -0.0069264069264069273, array(-1.5, -2.5, -3.5, -4.5, -5.5)),
			array(null, -0.0069264069264069273, array(-1.5, -2.5, -3.5, -4.5, -5.5, 0.0)),
			array(null, null,  array('', 'something5', 'else', 'what')),
			array(5,  0.041666666666666671, array(1, 2, 3, 4, 5)),
			array(5, -0.041666666666666671, array(-1, -2, -3, -4, -5)),
			array(5, -0.041666666666666671, array(-1, -2, -3, -4, -5, 0)),
			array(5,  0.015392015392015394, array(1.5, 2.5, 3.5, 4.5, 5.5)),
			array(5, -0.015392015392015394, array(-1.5, -2.5, -3.5, -4.5, -5.5)),
			array(5, -0.015392015392015394, array(-1.5, -2.5, -3.5, -4.5, -5.5, 0.0)),
			array(5, 5,  array('', 'something5', 'else', 'what')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers \Mimic\Functional\quotient
	 */
	public function testResults($initial, $result, $collection) {
		if ($initial === null) {
			$this->assertEquals($result, F\quotient($collection));
		}
		else {
			$this->assertEquals($result, F\quotient($collection, $initial));
		}
	}
}
