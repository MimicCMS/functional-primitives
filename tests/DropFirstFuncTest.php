<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class DropFirstFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\dropFirst
	 */
	public function testDropFirst2() {
		$callback = function($element, $index) {
			return $index < 2;
		};

		$collection = array(0, 1, 2, 3, 4, 5, 6);
		$expected = array(2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6);
		$actual = F\dropFirst($collection, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\dropFirst
	 */
	public function testIsEmptyArray() {
		$callback = function($element, $index) {
			return true;
		};

		$collection = array(0, 1, 2);
		$expected = array();
		$actual = F\dropFirst($collection, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\dropFirst
	 */
	public function testWhenElementIs2() {
		$callback = function($element, $index) {
			return $element !== 2;
		};

		$collection = array(0, 1, 3, 4, 2, 5, 6);
		$expected = array(4 => 2, 5 => 5, 6 => 6);
		$actual = F\dropFirst($collection, $callback);
		$this->assertEquals($expected, $actual);
	}
}
