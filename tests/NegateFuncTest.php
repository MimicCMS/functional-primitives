<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
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
			array(true, array()),
			array(false, array(1)),
			array(true, ''),
			array(false, 1),
			array(true, 0),
		);
	}

	public function dataProviderNegate() {
		return array(
			array(true, true),
			array(false, false),
			array(true, 'something'),
			array(false, ''),
			array(true, 1),
			array(false, 0),
		);
	}

	/**
	 * @dataProvider dataProviderTrue
	 * @covers ::Mimic\Functional\not
	 */
	public function testNegation_not($expected, $value) {
		$callback = F\not(function($element) {
			return !!$element;
		});
		$this->assertEquals($expected, $callback($value, null, null));
	}

	/**
	 * @dataProvider dataProviderNegate
	 * @covers ::Mimic\Functional\not
	 */
	public function testDoubleBang_not($expected, $value) {
		$callback = F\not(F\not(function($element) {
			return !!$element;
		}));
		$this->assertEquals($expected, $callback($value, null, null));
	}

	/**
	 * @dataProvider dataProviderTrue
	 * @covers ::Mimic\Functional\fails
	 */
	public function testNegation_fails($expected, $value) {
		$callback = F\fails(function($element) {
			return !!$element;
		});
		$this->assertEquals($expected, $callback($value, null, null));
	}

	/**
	 * @dataProvider dataProviderNegate
	 * @covers ::Mimic\Functional\fails
	 */
	public function testDoubleBang_fails($expected, $value) {
		$callback = F\fails(F\fails(function($element) {
			return !!$element;
		}));
		$this->assertEquals($expected, $callback($value, null, null));
	}
}
