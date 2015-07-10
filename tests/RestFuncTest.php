<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for rest Mimic library function.
 *
 * @since 0.1.0
 */
class RestFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\rest
	 */
	public function testDroppingLast2() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
		$actual = F\rest($collection, 2);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\rest
	 */
	public function testDroppingLastNeg2() {
		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
		$actual = F\rest($collection, -2);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\rest
	 */
	public function testOverArrayCount() {
		$collection = array(0, 1, 2, 3, 4, 5);
		$expected = array();
		$actual = F\rest($collection, 7);
		$this->assertEquals($expected, $actual);
	}
}
