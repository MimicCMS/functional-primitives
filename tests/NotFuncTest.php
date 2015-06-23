<?php

use Mimic\Functional as F;

/**
 * Unit Test for true Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class NotFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProviderTrue() {
		return array(
			array(false, true),
			array(true, false),
			array(false, array()),
			array(true, ''),
			array(false, 1),
			array(true, 0),
		);
	}

	public function dataProviderNegate() {
		return array(
			array(true, true),
			array(false, false),
			array(true, array()),
			array(false, ''),
			array(true, 1),
			array(false, 0),
		);
	}

	/**
	 * @dataProvider dataProviderTrue
	 * @covers \Mimic\Functional\not
	 */
	public function testNegation($expected, $value) {
		$callback = F\not(function($element) {
			return !!$element;
		});
		$this->assertEquals($expected, $callback($value));
	}

	/**
	 * @dataProvider dataProviderNegate
	 * @covers \Mimic\Functional\not
	 */
	public function testDoubleBang($expected, $value) {
		$callback = F\not(F\not(function($element) {
			return !$element;
		}));
		$this->assertEquals($expected, $callback($value));
	}
}
