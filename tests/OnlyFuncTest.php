<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for only Mimic library function.
 *
 * @since 0.1.0
 */
class OnlyFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$collection = array(
			'thing1' => 1,
			'thing2' => 2,
			'thing3' => 3,
			'some1' => 'thing',
			'some2' => 'thing',
			'some3' => 'thing',
			0 => 1,
			1 => 2,
			2 => 3,
		);
		return array(
			array($collection, array('thing1' => 1), array('thing1')),
			array($collection, array(0 => 1), array(0)),
			array($collection, array(0 => 1, 2 => 3), array(0, 2)),
			array($collection, array(), array('0')),
			array($collection, array(), array(5)),
			array($collection, array('thing2' => 2), array('thing2')),
			array($collection, array('thing3' => 3), array('thing3')),
			array($collection, array('some1' => 'thing', 'some3' => 'thing'), array('some1', 'some3')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\only
	 */
	public function testResults($collection, $expected, $keep) {
		$this->assertEquals($expected, F\only($collection, $keep));
	}
}
