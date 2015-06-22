<?php

use Mimic\Functional as F;

/**
 * Unit Test for minimum Mimic library function.
 *
 * @since 0.1.0
 */
class MinimumFuncTest extends PHPUnit_Framework_TestCase {
	public function testIsZero() {
		$this->assertEquals(0, F\minimum(array(0, 1, 2, 3, 4)));
	}

	public function testIsOneWithStrings() {
		$this->assertEquals(1, F\minimum(array(1, '', 'something', 'what', 1, 2)));
	}

	public function testWithFloatsGetsCorrect() {
		$this->assertEquals(1.5, F\minimum(array(1.5, 2.5, 2.5, 2.5, 3.5, 3.56)));
	}

	public function testWithoutNumericIsNull() {
		$this->assertEquals(null, F\minimum(array('', 'Something5', 'okay', 'what')));
	}
}
