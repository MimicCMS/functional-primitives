<?php

use Mimic\Functional as F;

/**
 * Unit Test for minimum Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class MinimumFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(1, array(1, 2, 3, 4, 5)),
			array(-1, array(-1, 0, 1, 200, 3, 4, 5)),
			array(0, array(0, '', 'something', 'what', 1, 2)),
			array(1.5, array(1.5, 2.5, 2.5, 2.5, 3.5, 3.56)),
			array(null, array('', 'Something5', 'okay', 'what')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\minimum
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\minimum($collection));
	}
}
