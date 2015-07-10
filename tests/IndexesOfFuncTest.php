<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for indexesOf Mimic library function.
 *
 * @since 0.1.0
 */
class IndexesOfFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(0, 1, false, false, true, true, 0, 1);
		return array(
			array(array(2, 3), false, true, $collection),
			array(array(0, 2, 3, 6), false, false, $collection),
			array(array(4, 5), true, true, $collection),
			array(array(1, 4, 5, 7), true, false, $collection),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\indexesOf
	 */
	public function testResults($expected, $value, $strict, $collection) {
		$this->assertEquals($expected, F\indexesOf($collection, $value, $strict));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\indexesOf
	 */
	public function testResultsCallback($expected, $value, $strict, $collection) {
		$self = $this;
		$callback = function($element, $index, $array) use ($self, $collection) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			return $index === 1;
		};
		$this->assertEquals(array(1), F\indexesOf($collection, $callback));
	}
}
