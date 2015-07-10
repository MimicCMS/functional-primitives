<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for memoize Mimic library function.
 *
 * @since 0.1.0
 */
class MemoizeFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\memoize
	 */
	public function testSameCallbackIsReturned() {
		$test = function() { return true; };
		$expected = F\memoize($test);
		$actual = F\memoize($test);
		$this->assertSame($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\memoize
	 */
	public function testCallParametersOnlyExecutesOnce() {
		$executed = array(0 => 0, 1 => 0, 2 => 0, 3 => 0);
		$test = function() use (&$executed) {
			$executed[func_num_args()] += 1;
			return func_get_args();
		};

		$callback = F\memoize($test);
		$this->assertEquals(array(), $callback());
		$this->assertEquals(1, $executed[0]);

		$this->assertEquals(array(), $callback());
		$this->assertEquals(1, $executed[0]);

		$this->assertEquals(array(1), $callback(1));
		$this->assertEquals(1, $executed[1]);

		$this->assertEquals(array(1), $callback(1));
		$this->assertEquals(1, $executed[1]);

		$this->assertEquals(array(), $callback());
		$this->assertEquals(1, $executed[0]);

		$this->assertEquals(array(1, 2), $callback(1, 2));
		$this->assertEquals(1, $executed[2]);

		$this->assertEquals(array(1, 2), $callback(1, 2));
		$this->assertEquals(1, $executed[2]);
	}

	/**
	 * @covers ::Mimic\Functional\memoize
	 */
	public function testCallParametersOnlyExecutesOnce_SameArgNum() {
		$executed = array();
		$test = function() use (&$executed) {
			$args = func_get_args();
			$hash = \json_encode($args);
			if (! isset($executed[ $hash ]) ) {
				$executed[ $hash ] = 0;
			}
			$executed[ $hash ] += 1;
			return $args;
		};

		$callback = F\memoize($test);

		$expected = array();
		$this->assertEquals($expected, $callback());
		$this->assertEquals(1, $executed[\json_encode($expected)]);

		$this->assertEquals($expected, $callback());
		$this->assertEquals(1, $executed[\json_encode($expected)]);

		$expected = array(1);
		$this->assertEquals($expected, $callback(1));
		$this->assertEquals(1, $executed[\json_encode($expected)]);

		$this->assertEquals($expected, $callback(1));
		$this->assertEquals(1, $executed[\json_encode($expected)]);

		$expected = array(2);
		$this->assertEquals($expected, $callback(2));
		$this->assertEquals(1, $executed[\json_encode($expected)]);

		$this->assertEquals($expected, $callback(2));
		$this->assertEquals(1, $executed[\json_encode($expected)]);
	}
}
