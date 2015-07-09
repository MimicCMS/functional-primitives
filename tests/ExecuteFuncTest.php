<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for either Mimic library function.
 *
 * @since 0.1.0
 */
class ExecuteFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\execute
	 */
	public function testIsEmpty() {
		$expected = array();
		$actual = F\execute();
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\execute
	 */
	public function testIsAllTrue() {
		$callback = function() { return true; };
		$expected = array(true, true, true);
		$actual = F\execute($callback, $callback, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\execute
	 */
	public function testIsAllFalse() {
		$callback = function() { return false; };
		$expected = array(false, false, false);
		$actual = F\execute($callback, $callback, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\execute
	 */
	public function testIsAllSomethingString() {
		$callback = function() { return 'something'; };
		$expected = array('something', 'something', 'something');
		$actual = F\execute($callback, $callback, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\execute
	 */
	public function testNotAllCallBacks() {
		$callback = function() { return true; };
		$expected = array(true, null, true, null);
		$actual = F\execute($callback, null, $callback, '__something__');
		$this->assertEquals($expected, $actual);
	}
}
