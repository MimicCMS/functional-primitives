<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for with Mimic library function.
 *
 * @since 0.1.0
 */
class WithFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$passthrough = function($value) {
			return $value;
		};
		$boolean = function($value) {
			return !!$value;
		};

		return array(
			array($passthrough, array(), array()),
			array($passthrough, 0, 0),
			array($passthrough, 1, 1),
			array($passthrough, true, true),
			array($passthrough, false, false),
			array($passthrough, (object) array(), (object) array()),
			array($passthrough, true, function() { return true; }),

			array($boolean, false, array()),
			array($boolean, true,  array(1)),
			array($boolean, false, 0),
			array($boolean, true,  1),
			array($boolean, true,  true),
			array($boolean, false, false),
			array($boolean, true,  (object) array()),
			array($boolean, true,  function() { return true; }),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\with
	 */
	public function testResults($callback, $expected, $value) {
		$this->assertEquals($expected, F\with($value, $callback));
	}
}
