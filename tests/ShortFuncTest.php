<?php

use Mimic\Functional as F;

/**
 * Unit Test for short Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class ShortFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$values = array_fill(0, 5, 1);
		$keys = array_fill_keys(array('index1', 'index2', 'index3', 'index4', 'index5'), 1);
		return array(
			array(false, true, true,  5, $values),
			array(false, true, false, 3, $values),
			array(false, true, true,  5, $keys),
			array(false, true, false, 3, $keys),
			array(true, false, true,  3, $values),
			array(true, false, false, 5, $values),
			array(true, false, true,  3, $keys),
			array(true, false, false, 5, $keys),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\short
	 */
	public function testResults($passed, $default, $expected, $stop, $data) {
		$executed = 0;
		$self = $this;

		$callback = function($element, $index, $collection) use ($data, $stop, $self, &$executed) {
			$executed += 1;
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
			return $executed >= $stop;
		};

		$this->assertEquals($expected, F\short($data, $passed, $default, $callback));
		$this->assertEquals($stop, $executed, 'stop does not equal executed');
	}
}
