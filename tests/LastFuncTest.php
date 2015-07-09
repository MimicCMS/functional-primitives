<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class LastFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(5, range(1, 5, 1)),
			array(200, range(100, 200, 10)),
			array('else', array('something', 'else')),
			array('world', array('hello', 'world')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\last
	 * @covers ::Mimic\Functional\tail
	 */
	public function testResults($expected, $collection) {
		$this->assertEquals($expected, F\last($collection));
		$this->assertEquals($expected, F\tail($collection));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\last
	 * @covers ::Mimic\Functional\tail
	 */
	public function testStateIsNotChanged($_, $collection) {
		$expected = next($collection);
		$value = F\last($collection);
		$actual = current($collection);

		$this->assertEquals($value, F\tail($collection));
		$this->assertEquals($expected, $actual);
		$this->assertNotEquals($value, $actual);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\last
	 * @covers ::Mimic\Functional\tail
	 */
	public function testResultsCallback($_, $collection) {
		$self = $this;
		$expected = null;
		$callback = function($element, $index, $array) use ($self, $collection, &$expected) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			if ( $index === 1 ) {
				$expected = $element;
				return true;
			}
			return false;
		};
		$this->assertEquals($expected, F\last($collection, $callback));
		$this->assertEquals($expected, F\tail($collection, $callback));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\last
	 * @covers ::Mimic\Functional\tail
	 */
	public function testStateIsNotChangedWithCallback($_, $collection) {
		$callback = function($element, $index, $array) use ($collection) {
			return $index === 1;
		};

		$expected = next($collection);
		$value = F\last($collection, $callback);
		$actual = current($collection);

		$this->assertEquals($value, F\tail($collection, $callback));
		$this->assertEquals($expected, $actual);
		$this->assertNotEquals($value, $actual);
	}
}
