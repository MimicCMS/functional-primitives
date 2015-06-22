<?php

use Mimic\Functional as F;

/**
 * Unit Test for product Mimic library function.
 *
 * @since 0.1.0
 */
class ProductFuncTest extends PHPUnit_Framework_TestCase {
	public function testIs120() {
		$this->assertEquals(120, F\product(array(1, 2, 3, 4, 5)));
	}

	public function testIsNegative120() {
		$this->assertEquals(-120, F\product(array(-1, -2, -3, -4, -5)));
	}

	public function testWithFloat() {
		$this->assertEquals(324.84375, F\product(array(1.5, 2.5, 3.5, 4.5, 5.5)));
	}

	public function testWithFloatIsNegativeFloat() {
		$this->assertEquals(-324.84375, F\product(array(1.5, 2.5, 3.5, 4.5, 5.5, -1)));
	}

	public function testWithStringIsOne() {
		$this->assertEquals(1, F\product(array('', 'something5', 'else', 'what')));
	}

	public function testIs600_withInitial() {
		$this->assertEquals(600, F\product(array(1, 2, 3, 4, 5), 5));
	}

	public function testIsNegative600_withInitial() {
		$this->assertEquals(-600, F\product(array(1, 2, 3, 4, 5, -1), 5));
	}

	public function testWithFloat_withInitial() {
		$this->assertEquals(1624.21875, F\product(array(1.5, 2.5, 3.5, 4.5, 5.5), 5));
	}

	public function testWithFloatIsNegativeFloat_withInitial() {
		$this->assertEquals(-1624.21875, F\product(array(1.5, 2.5, 3.5, 4.5, 5.5, -1), 5));
	}

	public function testWithStringIsFive_withInitial() {
		$this->assertEquals(5, F\product(array('', 'something5', 'else', 'what'), 5));
	}
}
