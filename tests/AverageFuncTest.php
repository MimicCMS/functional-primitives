<?php

use Mimic\Functional as F;

/**
 * Unit Test for average Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class AverageFuncTest extends PHPUnit_Framework_TestCase {
	public function testAverageIsTwo() {
		$this->assertEquals(2, F\average(array(0, 1, 2, 3, 4)));
	}

	public function testAverageIsTwo_withStrings() {
		$this->assertEquals(2, F\average(array(0, '', 'something', 'what', 1, 2, 3, 4)));
	}

	public function testAverageWithFloatsIsIncomplete() {
		$this->assertEquals(2.3333333333333335, F\average(array(1.5, 2.5, 2.5, 2.5, 3.5, 4)));
	}

	public function testAverageWithFloatsIsTwoAndAHalf() {
		$this->assertEquals(2.5, (float) F\average(array(2.5, 2.5, 2.5, 2.5, 2.5, 2.5)));
	}

	public function testAverageWithIntsIsTwo() {
		$this->assertEquals(2, F\average(array(2, 2, 2, 2, 2, 2)));
	}

	public function testAverageWithoutNumericIsZero() {
		$this->assertEquals(0, F\average(array('', 'Something5', 'okay', 'what')));
	}
}
