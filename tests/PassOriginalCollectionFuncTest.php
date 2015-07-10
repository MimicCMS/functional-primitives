<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for passOriginalCollection Mimic library function.
 *
 * @since 0.1.0
 */
class PassOriginalCollectionFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(5, range(1, 5, 1)),
			array(200, range(100, 200, 10)),
			array('anything', array('something', 'else', 'anything')),
			array('name', array('hello', 'world', 'name')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\passOriginalCollection
	 */
	public function testResults($_, $collection) {
		$self = $this;
		$callback = function($element, $index, $array) use ($self, $collection) {
			$self->assertEquals($collection, $array);
			$self->assertEquals($collection[ $index ], $element);
			return $element;
		};

		$process = F\passOriginalCollection($collection, $callback);

		$reversed = array_reverse($collection, true);
		foreach ( $reversed as $index => $expected ) {
			$actual = $process($expected, $index, $reversed);
			$this->assertEquals($expected, $actual);
		}
	}
}
