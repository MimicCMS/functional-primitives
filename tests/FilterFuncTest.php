<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for filter Mimic library function.
 *
 * @since 0.1.0
 */
class FilterFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testEverythingAccepted() {
		$collection = range(0, 10);
		$expected = $collection;
		$actual = F\filter($collection, function() { return true; });
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testNothingAccepted() {
		$collection = range(0, 10);
		$expected = array();
		$actual = F\filter($collection, function() { return false; });
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testOnlyOddElements() {
		$collection = range(0, 10);
		$expected = array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9);
		$actual = F\filter($collection, function($element) { return ! (($element % 2) === 0); });
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testOnlyEvenElements() {
		$collection = range(0, 10);
		$expected = array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10);
		$actual = F\filter($collection, function($element) { return (($element % 2) === 0); });
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testOnlyOddIndexes() {
		$collection = range(0, 10);
		$expected = array(1 => 1, 3 => 3, 5 => 5, 7 => 7, 9 => 9);
		$actual = F\filter($collection, function($element, $index) { return ! (($index % 2) === 0); });
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\filter
	 */
	public function testOnlyEvenIndexes() {
		$collection = range(0, 10);
		$expected = array(0 => 0, 2 => 2, 4 => 4, 6 => 6, 8 => 8, 10 => 10);
		$actual = F\filter($collection, function($element, $index) { return (($index % 2) === 0); });
		$this->assertEquals($expected, $actual);
	}
}
