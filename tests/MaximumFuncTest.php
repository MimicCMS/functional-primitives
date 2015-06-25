<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for maximum Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class MaximumFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(5, array(1, 2, 3, 4, 5)),
			array(200, array(-1, 0, 1, 200, 3, 4, 5)),
			array(2, array(0, '', 'something', 'what', 1, 2)),
			array(3.56, array(1.5, 2.5, 2.5, 2.5, 3.5, 3.56)),
			array(null, array('', 'Something5', 'okay', 'what')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\maximum
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\maximum($collection));
	}
}
