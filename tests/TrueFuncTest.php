<?php

use Mimic\Functional as F;

/**
 * Unit Test for true Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class TrueFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(false, array(false, true, false, false)),
			array(false, array('0', true, 1, -1)),
			array(false, array(1, 1, true, true)),
			array(false, array('something', 'else', true, false)),
			array(true,  array(true, true, true, true)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\true
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\true($collection));
	}
}
