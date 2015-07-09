<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class FirstFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(1, range(1, 5, 1)),
			array(100, range(100, 200, 10)),
			array('something', array('something', 'else')),
			array('hello', array('hello', 'world')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\first
	 * @covers ::Mimic\Functional\head
	 */
	public function testResults($expected, $collection) {
		$this->assertEquals($expected, F\first($collection));
		$this->assertEquals($expected, F\head($collection));
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\first
	 * @covers ::Mimic\Functional\head
	 */
	public function testStateIsNotChanged($_, $collection) {
		$expected = next($collection);
		$value = F\first($collection);
		$actual = current($collection);

		$this->assertEquals($value, F\head($collection));
		$this->assertEquals($expected, $actual);
		$this->assertNotEquals($value, $actual);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\first
	 * @covers ::Mimic\Functional\head
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

		$actual = F\first($collection, $callback);
		$this->assertEquals($expected, $actual);

		$actual = F\head($collection, $callback);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\first
	 * @covers ::Mimic\Functional\head
	 */
	public function testStateIsNotChangedWithCallback($_, $collection) {
		$callback = function($element, $index, $array) use ($collection) {
			return $index === 1;
		};

		$expected = next($collection);
		$value = F\first($collection, $callback);
		$actual = current($collection);

		$this->assertEquals($value, F\head($collection, $callback));
		$this->assertEquals($expected, $actual);
		$this->assertNotEquals($value, $actual);
	}
}
