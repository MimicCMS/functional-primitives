<?php

use Mimic\Functional as F;

/**
 * Unit Test for maximum Mimic library function.
 *
 * @since 0.1.0
 */
class MaximumFuncTest extends PHPUnit_Framework_TestCase {
	public function testIsFour() {
		$this->assertEquals(4, F\maximum(array(0, 1, 2, 3, 4)));
	}

	public function testIsTwoWithStrings() {
		$this->assertEquals(2, F\maximum(array(0, '', 'something', 'what', 1, 2)));
	}

	public function testWithFloatsGetsCorrect() {
		$this->assertEquals(3.56, F\maximum(array(1.5, 2.5, 2.5, 2.5, 3.5, 3.56)));
	}

	public function testWithoutNumericIsNull() {
		$this->assertEquals(null, F\maximum(array('', 'Something5', 'okay', 'what')));
	}
}
