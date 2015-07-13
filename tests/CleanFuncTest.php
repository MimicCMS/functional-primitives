<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for clean Mimic library function.
 *
 * @since 0.1.0
 */
class CleanFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(array(0 => 1, 3 => 2, 4 => 3, 5 => 4), array(1, false, 0, 2, 3, 4, '')),
			array(array(0 => 'something', 1 => 'else', 5 => 'hello'), array('something', 'else', false, 0, '', 'hello')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\clean
	 */
	public function testResults($expected, $collection) {
		$this->assertEquals($expected, F\clean($collection));
	}
}
