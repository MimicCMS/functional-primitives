<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for truthy Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class TruthyFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(false, array(false, true, false, false)),
			array(false, array('0', true, 0, '')),
			array(true, array(1, 'something', '1', true)),
			array(true, array(1, -1, 'false', true)),
			array(true,  array(true, true, true, true)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\truthy
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\truthy($collection));
	}
}
