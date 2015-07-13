<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for pluck Mimic library function.
 *
 * @since 0.1.0
 */
class PluckFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			array('index1' => 1, 'index2' => 2, 'index3' => 3),
			array('index1' => 4, 'index2' => 5, 'index3' => 6),
			array('index1' => 7, 'index2' => 8, 'index3' => 9),
		);

		$first = new Fake\InvokeTrue;
		$first->one = 1;
		$first->two = 2;
		$first->something = 1;

		$second = new Fake\InvokeTrue;
		$second->one = 3;
		$second->two = 4;
		$second->something = 2;

		$three = new Fake\InvokeTrue;
		$three->one = 5;
		$three->two = 6;
		$three->something = 3;

		$objects = array($first, $second, $three);

		return array(
			array($collection, array(1, 4, 7), 'index1'),
			array($collection, array(2, 5, 8), 'index2'),
			array($collection, array(3, 6, 9), 'index3'),
			array($collection, array(), 'index4'),
			array($objects, array(), 'hello'),
			array($objects, array(1, 3, 5), 'one'),
			array($objects, array(2, 4, 6), 'two'),
			array($objects, array(1, 2, 3), 'something'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\pluck
	 */
	public function testResults($collection, $expected, $name) {
		$this->assertEquals($expected, F\pluck($collection, $name));
	}
}
