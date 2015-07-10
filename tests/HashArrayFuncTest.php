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
		return array(
			array(),
			array(1, 2, 3),
			array(new Stub\InvokeTrue, new Stub\InvokeFalse, 1, 2),
			array(1, 2, new Stub\InvokeTrue, new Stub\InvokeFalse),
			array(function() { return true; }),
			array(1, function() { return true; }),
			array(0, 1, function() { return true; }),
			array(0, 1, function() { return true; }, new Stub\InvokeTrue),
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
