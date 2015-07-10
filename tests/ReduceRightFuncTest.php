<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for reduceRight Mimic library function.
 *
 * @since 0.1.0
 */
class ReduceRightFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider_numbers() {
		return array(
			array(0, array(1, 2, 3, 4)),
			array(5, array(1, 2, 3, 4)),
			array(0, array(1.5, 2.25, 3.5, 4.75)),
			array(5, array(1, 2, 3, 4)),
		);
	}

	/**
	 * @dataProvider dataProvider_numbers
	 * @covers ::Mimic\Functional\reduceRight
	 */
	public function testSumResults($initial, $data) {
		$self = $this;

		$callback = function($element, $initial, $index, $collection) use ($data, $self) {
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
			return $element + $initial;
		};

		$expected = array_reduce(array_reverse($data), $callback, $initial);

		$this->assertEquals($expected, F\reduceRight($data, $callback, $initial));
	}

	/**
	 * @dataProvider dataProvider_numbers
	 * @covers ::Mimic\Functional\reduceRight
	 */
	public function testDifferenceResults($initial, $data) {
		$self = $this;

		$callback = function($element, $initial, $index, $collection) use ($data, $self) {
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
			return $element - $initial;
		};

		$expected = array_reduce(array_reverse($data), $callback, $initial);

		$this->assertEquals($expected, F\reduceRight($data, $callback, $initial));
	}

	/**
	 * @covers ::Mimic\Functional\reduceRight
	 */
	public function testAppendString() {
		$data = array('something', 'else', 'hello', 'world');

		$callback = function($element, $initial) {
			return $initial .' '. $element;
		};

		$expected = ' world hello else something';

		$this->assertEquals($expected, F\reduceRight($data, $callback, ''));
	}

	/**
	 * @covers ::Mimic\Functional\reduceRight
	 */
	public function testPrependString() {
		$data = array('something', 'else', 'hello', 'world');

		$callback = function($element, $initial) {
			return $element .' '. $initial;
		};

		$expected = 'something else hello world ';

		$this->assertEquals($expected, F\reduceRight($data, $callback, ''));
	}
}
