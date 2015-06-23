<?php

use Mimic\Functional as F;

/**
 * Unit Test for average Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class AverageFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(2.5, array(1, 2, 3, 4)),
			array(2, array(0, '', 'something', 'what', 1, 2, 3, 4)),
			array(2.75, array(1.5, 2.5, 2.5, 2.5, 3.5, 4)),
			array(2.5, array(2.5, 2.5, 2.5, 2.5, 2.5, 2.5)),
			array(2, array(2, 2, 2, 2, 2, 2)),
			array(0, array('', 'Something5', 'okay', 'what')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers \Mimic\Functional\average
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\average($collection));
	}
}
