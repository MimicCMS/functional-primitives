<?php

use Mimic\Functional as F;

/**
 * Unit Test for falsy Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class FalsyFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(false, array(false, true, false, false)),
			array(false, array('0', true, false, false)),
			array(true, array(0, 0, false, false)),
			array(true, array('', '', false, false)),
			array(true,  array(false, false, false, false)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\falsy($collection));
	}
}
