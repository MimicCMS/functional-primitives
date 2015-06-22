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
	public function testIsNegative15() {
		$this->assertEquals(-15, F\difference(array(1, 2, 3, 4, 5)));
	}

	public function testIs15() {
		$this->assertEquals(15, F\difference(array(-1, -2, -3, -4, -5)));
	}

	public function testWithFloatIsNegativeFloat() {
		$this->assertEquals(-17.5, F\difference(array(1.5, 2.5, 3.5, 4.5, 5.5)));
	}

	public function testWithFloatIsFloat() {
		$this->assertEquals(17.5, F\difference(array(-1.5, -2.5, -3.5, -4.5, -5.5)));
	}

	public function testWithStringIsZero() {
		$this->assertEquals(0, F\difference(array('', 'something5', 'else', 'what')));
	}

	public function testIsNegative15_initialValue() {
		$this->assertEquals(-20, F\difference(array(1, 2, 3, 4, 5), 5));
	}

	public function testIs15_initialValue() {
		$this->assertEquals(20, F\difference(array(-1, -2, -3, -4, -5), -5));
	}

	public function testWithFloatIsNegativeFloat_initialValue() {
		$this->assertEquals(-22.5, F\difference(array(1.5, 2.5, 3.5, 4.5, 5.5), 5));
	}

	public function testWithFloatIsFloat_initialValue() {
		$this->assertEquals(23, F\difference(array(-1.5, -2.5, -3.5, -4.5, -5.5), -5.5));
	}

	public function testWithStringIsZero_initialValue() {
		$this->assertEquals(5, F\difference(array('', 'something5', 'else', 'what'), 5));
	}
}
