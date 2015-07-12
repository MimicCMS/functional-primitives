<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for sortable Mimic library function.
 *
 * @since 0.1.0
 */
class SortableFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\sortable
	 */
	public function testNormal() {
		$callback = F\sortable();
		$this->assertEquals(0, $callback(0, 0));
		$this->assertEquals(0, $callback(1, 1));
		$this->assertEquals(0, $callback(1, '1'));
		$this->assertEquals(-1, $callback(1, 2));
		$this->assertEquals(-1, $callback(1, '2'));
		$this->assertEquals(-1, $callback('1', '2'));
		$this->assertEquals(1, $callback(2, 1));
		$this->assertEquals(1, $callback('2', 1));
		$this->assertEquals(0, $callback('something', 'something'));
	}

	/**
	 * @covers ::Mimic\Functional\sortable
	 */
	public function testReversed() {
		$callback = F\sortable(true);
		$this->assertEquals(0, $callback(0, 0));
		$this->assertEquals(0, $callback(1, 1));
		$this->assertEquals(1, $callback(1, '1'));
		$this->assertEquals(1, $callback(1, 2));
		$this->assertEquals(1, $callback(1, '2'));
		$this->assertEquals(1, $callback('1', '2'));
		$this->assertEquals(-1, $callback(2, 1));
		$this->assertEquals(-1, $callback('2', 1));
		$this->assertEquals(0, $callback('something', 'something'));
	}
}
