<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for partition Mimic library function.
 *
 * @since 0.1.0
 */
class PartitionFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\partition
	 */
	public function testSeparateEvenFromOdd() {
		$callback = function($element) {
			return ($element % 2) === 0;
		};

		$collection = range(1, 10);

		$expected = array(
			0 =>  array(0 => 1, 2 => 3, 4 => 5, 6 => 7, 8 => 9),
			1 => array(1 => 2, 3 => 4, 5 => 6, 7 => 8, 9 => 10),
		);
		$actual = F\partition($collection, $callback);
		$this->assertEquals($expected, $actual);
	}
}
