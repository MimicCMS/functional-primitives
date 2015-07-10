<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for group Mimic library function.
 *
 * @since 0.1.0
 */
class GroupFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\group
	 */
	public function testSeparateEvenAndOdd() {
		$callback = function($element) {
			if ( ($element % 2) === 0 ) {
				return 'even';
			}
			return 'odd';
		};

		$collection = range(1, 10);

		$expected = array(
			'odd' =>  array(0 => 1, 2 => 3, 4 => 5, 6 => 7, 8 => 9),
			'even' => array(1 => 2, 3 => 4, 5 => 6, 7 => 8, 9 => 10),
		);
		$actual = F\group($collection, $callback);
		$this->assertEquals($expected, $actual);
	}
}
