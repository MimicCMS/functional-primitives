<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for has Mimic library function.
 *
 * @since 0.1.0
 */
class HasFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			'thing1' => 1,
			'thing2' => 2,
			'thing3' => 3,
			0 => 1,
			1 => 2,
			2 => 3,
		);
		return array(
			array($collection, true, 'thing1'),
			array($collection, true, 0),
			array($collection, false, '0'),
			array($collection, false, 5),
			array($collection, true, 'thing2'),
			array($collection, true, 'thing3'),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\has
	 */
	public function testResults($collection, $expected, $keep) {
		$this->assertEquals($expected, F\has($collection, $keep));
	}
}
