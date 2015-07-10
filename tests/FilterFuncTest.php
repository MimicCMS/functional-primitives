<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for filter Mimic library function.
 *
 * @since 0.1.0
 */
class FilterFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$range = range(0, 10);
		return array(
			array($range, $range, function() { return true; }),
			array($range, array(), function() { return false; }),
			array($range, array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9), function($element) { return ! (($element % 2) === 0); }),
			array($range, array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10), function($element) { return (($element % 2) === 0); }),
			array($range, array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9), function($element, $index) { return ! (($index % 2) === 0); }),
			array($range, array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10), function($element, $index) { return (($index % 2) === 0); }),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\filter
	 * @covers ::Mimic\Functional\select
	 */
	public function testResults($collection, $expected, $callback) {
		$this->assertEquals($expected, F\filter($collection, $callback));
		$this->assertEquals($expected, F\select($collection, $callback));
	}
}
