<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for reduceNumber Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class ReduceNumberFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(0, 1, true, array(1)),
			array(0, 1.25, true, array(1.25)),
			array(0, '1', true, array('1')),
			array(0, '1.25', true, array('1.25')),
			array(1, 1, false, array('something')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\reduceNumber
	 */
	public function testCallbackIsCalledAndPassesResult($initial, $expected, $willBeCalled, $collection) {
		$called = false;
		$callback = function($element) use (&$called) {
			$called = true;
			return $element;
		};
		$actual = F\reduceNumber($collection, $initial, $callback);
		$this->assertEquals($willBeCalled, $called);
		$this->assertEquals($expected, $actual);
	}
}
