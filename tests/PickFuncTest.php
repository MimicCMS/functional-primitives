<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for pick Mimic library function.
 *
 * @since 0.1.0
 */
class PickFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			'index1' => 1,
			'index2' => 2,
			'index3' => 3,
		);
		return array(
			array($collection, 1, 'index1', null, null),
			array($collection, null, 'index4', null, null),
			array($collection, false, 'index4', false, null),
			array($collection, true, 'index4', true, null),
			array($collection, 3, 'index3', null, null),
			array($collection, null, 'index3', null, function() { return false; }),
			array($collection, true, 'index3', true, function() { return false; }),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\pick
	 */
	public function testResults($collection, $expected, $index, $default, $callback) {
		$this->assertEquals($expected, F\pick($collection, $index, $default, $callback));
	}
}
