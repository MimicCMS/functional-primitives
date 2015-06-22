<?php

use Mimic\Functional as F;

/**
 * Unit Test for sum Mimic library function.
 *
 * @since 0.1.0
 */
class SumFuncTest extends PHPUnit_Framework_TestCase {
	public function testIs15() {
		$this->assertEquals(15, F\sum(array(1, 2, 3, 4, 5)));
	}

	public function testIsNegative15() {
		$this->assertEquals(-15, F\sum(array(-1, -2, -3, -4, -5)));
	}

	public function testWithFloatIsFloat() {
		$this->assertEquals(17.5, F\sum(array(1.5, 2.5, 3.5, 4.5, 5.5)));
	}

	public function testWithFloatIsNegativeFloat() {
		$this->assertEquals(-17.5, F\sum(array(-1.5, -2.5, -3.5, -4.5, -5.5)));
	}

	public function testWithStringIsZero() {
		$this->assertEquals(0, F\sum(array('', 'something5', 'else', 'what')));
	}

	public function testIs20_withInitial() {
		$this->assertEquals(20, F\sum(array(1, 2, 3, 4, 5), 5));
	}

	public function testIsNegative10_withInitial() {
		$this->assertEquals(-10, F\sum(array(-1, -2, -3, -4, -5), 5));
	}

	public function testWithFloatIsFloat_withInitial() {
		$this->assertEquals(22.5, F\sum(array(1.5, 2.5, 3.5, 4.5, 5.5), 5));
	}

	public function testWithFloatIsNegativeFloat_withInitial() {
		$this->assertEquals(-12.5, F\sum(array(-1.5, -2.5, -3.5, -4.5, -5.5), 5));
	}

	public function testWithStringIsFive_withInitial() {
		$this->assertEquals(5, F\sum(array('', 'something5', 'else', 'what'), 5));
	}
}
