<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for partialLeft Mimic library function.
 *
 * @since 0.1.0
 */
class PartialLeftFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\partialLeft
	 */
	public function testArraySum() {
		$expected = array_sum(4, 5, 6, 1, 2, 3);
		$callback = F\partialLeft('array_sum', 1, 2, 3);
		$this->assertEquals($expected, $callback(4, 5, 6));
	}

	/**
	 * @covers ::Mimic\Functional\partialLeft
	 */
	public function testArrayMerge() {
		$expected = array(4, 5, 6, 1, 2, 3);
		$callback = F\partialLeft('array_merge', array(1, 2, 3));
		$this->assertEquals($expected, $callback(4, 5, 6));
	}
}
