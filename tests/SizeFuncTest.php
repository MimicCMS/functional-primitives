<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;
use ArrayIterator;

/**
 * Unit Test for size Mimic library function.
 *
 * @since 0.1.0
 */
class SizeFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\size
	 */
	public function testNotObjectNorArray() {
		$this->assertEquals(0, F\size(null));
		$this->assertEquals(0, F\size('something'));
		$this->assertEquals(0, F\size(1));
		$this->assertEquals(0, F\size(1.0));
	}

	/**
	 * @covers ::Mimic\Functional\size
	 */
	public function testCountableorArray() {
		$this->assertEquals(0, F\size(array()));
		$this->assertEquals(0, F\size(new Fake\SizeCount(0)));
		$this->assertEquals(1, F\size(array(1)));
		$this->assertEquals(1, F\size(new Fake\SizeCount(1)));
		$this->assertEquals(2, F\size(array(1, 2)));
		$this->assertEquals(2, F\size(new Fake\SizeCount(2)));
	}

	/**
	 * @covers ::Mimic\Functional\size
	 */
	public function testIteratorToArray() {
		foreach (range(0, 5) as $expected) {
			$this->assertEquals($expected, F\size(new Fake\Size($expected)));
		}
	}

	/**
	 * @covers ::Mimic\Functional\size
	 */
	public function testNotIterator() {
		$this->assertEquals(0, F\size((object) array()));
	}
}
