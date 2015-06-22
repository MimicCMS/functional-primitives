<?php

use Mimic\Functional as F;

/**
 * Unit Test for difference Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class DifferenceFuncTest extends PHPUnit_Framework_TestCase {
	public function testDifferenceIsNegative15() {
		$this->assertEquals(-15, F\difference(array(1, 2, 3, 4, 5)));
	}

	public function testDifferenceIs15() {
		$this->assertEquals(15, F\difference(array(-1, -2, -3, -4, -5)));
	}

	public function testDifferenceWithFloatIsNegativeFloat() {
		$this->assertEquals(-17.5, F\difference(array(1.5, 2.5, 3.5, 4.5, 5.5)));
	}

	public function testDifferenceWithFloatIsFloat() {
		$this->assertEquals(17.5, F\difference(array(-1.5, -2.5, -3.5, -4.5, -5.5)));
	}

	public function testDifferenceWithStringIsZero() {
		$this->assertEquals(0, F\difference(array('', 'something5', 'else', 'what')));
	}

	public function testDifferenceIsNegative15_initialValue() {
		$this->assertEquals(-20, F\difference(array(1, 2, 3, 4, 5), 5));
	}

	public function testDifferenceIs15_initialValue() {
		$this->assertEquals(20, F\difference(array(-1, -2, -3, -4, -5), -5));
	}

	public function testDifferenceWithFloatIsNegativeFloat_initialValue() {
		$this->assertEquals(-22.5, F\difference(array(1.5, 2.5, 3.5, 4.5, 5.5), 5));
	}

	public function testDifferenceWithFloatIsFloat_initialValue() {
		$this->assertEquals(23, F\difference(array(-1.5, -2.5, -3.5, -4.5, -5.5), -5.5));
	}

	public function testDifferenceWithStringIsZero_initialValue() {
		$this->assertEquals(5, F\difference(array('', 'something5', 'else', 'what'), 5));
	}
}
