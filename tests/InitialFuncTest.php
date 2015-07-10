<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for initial Mimic library function.
 *
 * @since 0.1.0
 */
class InitialFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\initial
	 */
	public function testDroppingLast2() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4);
		$actual = F\initial($collection, 2);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\initial
	 */
	public function testDroppingLastNeg2() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4);
		$actual = F\initial($collection, -2);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\initial
	 */
	public function testOverArrayCount() {
		$collection = array(0, 1, 2, 3, 4, 5);
		$expected = array();
		$actual = F\initial($collection, 7);
		$this->assertEquals($expected, $actual);
	}
}
