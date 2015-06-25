<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for false Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class FalseFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(false, array(false, true, false, false)),
			array(false, array(0, 0, false, false)),
			array(false, array('', '', false, false)),
			array(true,  array(false, false, false, false)),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\false
	 */
	public function testResults($result, $collection) {
		$this->assertEquals($result, F\false($collection));
	}
}
