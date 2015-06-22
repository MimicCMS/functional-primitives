<?php

use Mimic\Functional as F;

/**
 * Unit Test for sum Mimic library function.
 *
 * @since 0.1.0
 */
class SumFuncTest extends PHPUnit_Framework_TestCase {
	public function testDifferenceIsNegative15() {
		$this->assertEquals(15, F\sum(array(1, 2, 3, 4, 5)));
	}

	public function testDifferenceIs15() {
		$this->assertEquals(-15, F\sum(array(-1, -2, -3, -4, -5)));
	}

	public function testDifferenceWithFloatIsNegativeFloat() {
		$this->assertEquals(17.5, F\sum(array(1.5, 2.5, 3.5, 4.5, 5.5)));
	}

	public function testDifferenceWithFloatIsFloat() {
		$this->assertEquals(-17.5, F\sum(array(-1.5, -2.5, -3.5, -4.5, -5.5)));
	}

	public function testDifferenceWithStringIsZero() {
		$this->assertEquals(0, F\sum(array('', 'something5', 'else', 'what')));
	}

	public function testDifferenceIsNegative15_withInitial() {
		$this->assertEquals(20, F\sum(array(1, 2, 3, 4, 5), 5));
	}

	public function testDifferenceIs15_withInitial() {
		$this->assertEquals(-10, F\sum(array(-1, -2, -3, -4, -5), 5));
	}

	public function testDifferenceWithFloatIsNegativeFloat_withInitial() {
		$this->assertEquals(22.5, F\sum(array(1.5, 2.5, 3.5, 4.5, 5.5), 5));
	}

	public function testDifferenceWithFloatIsFloat_withInitial() {
		$this->assertEquals(-12.5, F\sum(array(-1.5, -2.5, -3.5, -4.5, -5.5), 5));
	}

	public function testDifferenceWithStringIsZero_withInitial() {
		$this->assertEquals(5, F\sum(array('', 'something5', 'else', 'what'), 5));
	}
}
