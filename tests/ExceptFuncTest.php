<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for except Mimic library function.
 *
 * @since 0.1.0
 */
class ExceptFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			'index1' => 1,
			'index2' => 2,
			'index3' => 3,
			'index4' => 4,
		);
		return array(
			array($collection, array('index2' => 2, 'index3' => 3, 'index4' => 4), array('index1')),
			array($collection, array('index2' => 2, 'index4' => 4), array('index1', 'index3')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\except
	 */
	public function testResults($collection, $expected, $parameters) {
		$this->assertEquals($expected, F\except($collection, $parameters));
		$this->assertEquals($expected, call_user_func_array('F\except', array_merge(array($collection), $parameters)));
	}
}
