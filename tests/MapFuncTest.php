<?php

use Mimic\Functional as F;

/**
 * Unit Test for map Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class MapFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(1, 2, 3)),
			array(array('hello', 'world', 'something', 'else')),
			array(array(
				3 => 1,
				4 => 2,
				5 => 3,
			)),
			array(array(
				'index-1' => 'hello',
				'index-2' => 'world',
				'index-3' => 'something',
				'index-4' => 'else',
			)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\map
	 */
	public function testResults($data) {
		$self = $this;
		$executed = 0;

		$actual = F\map($data, function($element, $index, $collection) use ($data, $self, &$executed) {
			$executed += 1;
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
			return true;
		});

		$expected = array_fill_keys(array_keys($data), array_fill(0, count($data), true));

		$this->assertEquals(count($data), $executed);
		$this->assertEquals($expected, $actual);
	}
}
