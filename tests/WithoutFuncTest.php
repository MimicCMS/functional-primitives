<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for without Mimic library function.
 *
 * @since 0.1.0
 */
class WithoutFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			'index1' => 1,
			'index2' => 2,
			'index3' => 3,
			'index4' => 4,
		);
		return array(
			array($collection, array('index2' => 2, 'index3' => 3, 'index4' => 4), array(1)),
			array($collection, array('index2' => 2, 'index4' => 4), array(1, 3)),
			array($collection, array('index1' => 1, 'index3' => 3), array(2, 4)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\without
	 */
	public function testResults($collection, $expected, $parameters) {
		$this->assertEquals($expected, F\without($collection));
		$this->assertEquals($expected, call_user_func_array('F\without', array_merge(array($collection), $parameters)));
	}
}
