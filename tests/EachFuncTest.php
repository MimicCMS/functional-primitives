<?php

use Mimic\Functional as F;

/**
 * Unit Test for each Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class EachFuncTest extends PHPUnit_Framework_TestCase {
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
	 * @covers ::Mimic\Functional\each
	 */
	public function testResults($data) {
		$self = $this;
		$actual = 0;

		F\each($data, function($element, $index, $collection) use ($data, $self, &$actual) {
			$actual += 1;
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
		});

		$this->assertEquals(count($data), $actual);
	}
}
