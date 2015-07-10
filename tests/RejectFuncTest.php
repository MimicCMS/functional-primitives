<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for reject Mimic library function.
 *
 * @since 0.1.0
 */
class RejectFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$range = range(0, 10);
		return array(
			array($range, array(), function() { return true; }),
			array($range, $range, function() { return false; }),
			array($range, array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10), function($element) { return ! (($element % 2) === 0); }),
			array($range, array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9), function($element) { return (($element % 2) === 0); }),
			array($range, array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10), function($element, $index) { return ! (($index % 2) === 0); }),
			array($range, array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9), function($element, $index) { return (($index % 2) === 0); }),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\reject
	 */
	public function testResults($collection, $expected, $callback) {
		$this->assertEquals($expected, F\reject($collection, $callback));
	}
}
