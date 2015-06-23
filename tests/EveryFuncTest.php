<?php

use Mimic\Functional as F;

/**
 * Unit Test for every Mimic library function.
 *
 * @since 0.1.0
 */
class EveryFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider_Passthrough() {
		return array( array(true), array(false) );
	}

	/**
	 * @dataProvider dataProvider_Passthrough
	 * @covers ::Mimic\Functional\every
	 */
	public function testPassthrough($passthrough) {
		$self = $this;
		$data = array(1, 1, 1, 1);

		$callback = function($element, $index, $collection) use ($data, $self, $passthrough) {
			$self->assertTrue((is_string($index) || is_numeric($index)), 'index is not correct type');
			$self->assertTrue(array_key_exists($index, $data), 'index does not exist in given data');
			$self->assertEquals($data[$index], $element, 'existing array does not match given element');
			$self->assertEquals($data, $collection, 'given collection does not match data');
			return $passthrough;
		};

		$this->assertEquals($passthrough, F\every($data, $callback));
	}
}
