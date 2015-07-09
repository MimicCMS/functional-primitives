<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for lastIndexOf Mimic library function.
 *
 * @since 0.1.0
 */
class LastIndexOfFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$boolean = array(0, 1, false, false, true, true, 0, 1);
		$integer = array('1', 1, 1, '1');
		$float = array('1.2', 1, 1.2, 1.2, '1.2');
		$collection = array(0, 1, false, true, 1.0, 'something', 'else', '1', '1', 1);
		return array(
			array(3, false, true, $boolean),
			array(6, false, false, $boolean),
			array(5, true, true, $boolean),
			array(7, true, false, $boolean),
			array(2, 1, true, $integer),
			array(3, 1, false, $integer),
			array(3, 1.2, true, $float),
			array(4, 1.2, false, $float),
			array(8, '1', true, $collection),
			array(9, '1', false, $collection),
			array(6, 'else', true, $collection),
			array(5, 'something', true, $collection),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\lastIndexOf
	 */
	public function testResults($expected, $value, $strict, $collection) {
		$this->assertEquals($expected, F\lastIndexOf($collection, $value, $strict));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\lastIndexOf
	 */
	public function testResultsCallback($expected, $value, $strict, $collection) {
		$self = $this;
		$callback = function($element, $index, $array) use ($self, $collection) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			return $index === 1;
		};
		$this->assertEquals(1, F\lastIndexOf($collection, $callback));
	}
}
