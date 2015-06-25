<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for difference Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class DifferenceFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(null, -15, array(1, 2, 3, 4, 5)),
			array(null, 15, array(-1, -2, -3, -4, -5)),
			array(null, 15, array(-1, -2, -3, -4, -5, 0)),
			array(null, -17.5, array(1.5, 2.5, 3.5, 4.5, 5.5)),
			array(null, 17.5, array(-1.5, -2.5, -3.5, -4.5, -5.5)),
			array(null, 0,  array('', 'something5', 'else', 'what')),
			array(5, -10, array(1, 2, 3, 4, 5)),
			array(5, 20, array(-1, -2, -3, -4, -5)),
			array(5, 20, array(-1, -2, -3, -4, -5, 0)),
			array(5, -12.5, array(1.5, 2.5, 3.5, 4.5, 5.5)),
			array(-5.5, 12, array(-1.5, -2.5, -3.5, -4.5, -5.5)),
			array(5, 5, array('', 'something5', 'else', 'what')),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\difference
	 */
	public function testResults($initial, $result, $collection) {
		if ($initial === null) {
			$this->assertEquals($result, F\difference($collection));
		}
		else {
			$this->assertEquals($result, F\difference($collection, $initial));
		}
	}
}
