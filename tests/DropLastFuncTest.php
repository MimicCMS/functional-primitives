<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropLast Mimic library function.
 *
 * @since 0.1.0
 */
class DropLastFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\dropLast
	 */
	public function testDropLast4() {
		$callback = function($element, $index) {
			return $index > 2;
		};

		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(0 => 0, 1 => 1, 2 => 2);
		$actual = F\dropLast($collection, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\dropLast
	 */
	public function testIsEmptyArray() {
		$callback = function($element, $index) {
			return true;
		};

		$collection = array(0, 1, 2);
		$expected = array();
		$actual = F\dropLast($collection, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\dropLast
	 */
	public function testWhenElementIsNot2() {
		$callback = function($element) {
			return $element === 2;
		};

		$collection = array(0, 1, 3, 4, 2, 5, 6);
		$expected = array(0 => 0, 1 => 1, 2 => 3, 3 => 4);
		$actual = F\dropLast($collection, $callback);
		$this->assertEquals($expected, $actual);
	}
}
