<?php

use Mimic\Functional as F;

/**
 * Unit Test for reduceNumber Mimic library function.
 *
 * @since 0.1.0
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
	 */
	public function testCallbackIsCalledAndPassesResult($initial, $expected, $willBeCalled, $collection) {
		$called = false;
		$callback = function($element, $current) use (&$called) {
			$called = true;
			return $element;
		};
		$actual = F\reduceNumber($collection, $initial, $callback);
		$this->assertEquals($willBeCalled, $called);
		$this->assertEquals($expected, $actual);
	}
}
