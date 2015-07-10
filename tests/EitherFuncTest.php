<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for either Mimic library function.
 *
 * @since 0.1.0
 */
class EitherFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array('something'),
			array(0),
			array(1),
			array(true),
			array(1.0),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\either
	 */
	public function testFirstCallbackValue($expected) {
		$left = function() use ($expected) { return $expected; };
		$right = function() { return false; };
		$this->assertEquals($expected, F\apply(F\either($left, $right)));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\either
	 */
	public function testSecondCallbackValue($expected) {
		$left = function() { return false; };
		$right = function() use ($expected) { return $expected; };
		$this->assertEquals($expected, F\apply(F\either($left, $right)));
	}
}
