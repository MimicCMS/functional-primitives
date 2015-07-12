<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for partialRight Mimic library function.
 *
 * @since 0.1.0
 */
class PartialRightFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\partialRight
	 */
	public function testInvokeIf_InvokeTrue() {
		$callback = F\partialRight('\Mimic\Functional\invokeIf', new Fake\InvokeTrue);
		$this->assertTrue($callback('exists'));
		$this->assertEquals(array(1, 2, 3), $callback('with', array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\partialRight
	 */
	public function testArrayMerge() {
		$expected = array(1, 2, 3, 4, 5, 6);
		$callback = F\partialRight('array_merge', array(1, 2, 3));
		$this->assertEquals($expected, $callback(4, 5, 6));
	}
}
