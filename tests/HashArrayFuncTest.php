<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for hash_array Mimic library function.
 *
 * @since 0.1.0
 */
class HashArrayFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$callback = function() { return true; };
		return array(
			array(
				array(),
				''
			),
			array(
				array(1, 2, 3),
				''
			),
			array(
				array(new Stub\InvokeTrue, new Stub\InvokeFalse, 1, 2),
				''
			),
			array(
				array(1, 2, new Stub\InvokeTrue, new Stub\InvokeFalse),
				''
			),
			array(
				array($callback),
				''
			),
			array(
				array(1, $callback),
				''
			),
			array(
				array(0, 1, $callback),
				''
			),
			array(
				array(0, 1, $callback, new Stub\InvokeTrue),
				''
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\hash_array
	 */
	public function testResults($args, $expected) {
		$this->assertEquals($expected, F\hash_array($args));
	}
}
