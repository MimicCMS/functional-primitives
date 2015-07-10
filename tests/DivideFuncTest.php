<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for divide Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class DivideFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(
				array(1, 2, 3),
				array(array(0, 1, 2), array(1, 2, 3))
			),
			array(
				array('thing1' => 1, 'thing2' => 2, 'thing3' => 3),
				array(array('thing1', 'thing2', 'thing3'), array(1, 2, 3))
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\divide
	 */
	public function testResults($collection, $expected) {
		$actual = F\divide($collection);
		$this->assertEquals($expected, $actual);
	}
}
