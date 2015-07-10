<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional\MemoizeCache;

/**
 * Unit Test for MemoizeCache Mimic library class.
 *
 * @since 0.1.0
 */
class MemoizeCacheFuncTest extends PHPUnit_Framework_TestCase {

	private $memoize;

	private $executed = array();

	public function setUp() {
		$self = $this;
		$test = function() use ($self) {
			$args = func_get_args();
			$hash = \json_encode($args);
			if (! isset($self->executed[ $hash ]) ) {
				$self->executed[ $hash ] = 0;
			}
			$self->executed[ $hash ] += 1;
			return $args;
		};

		$this->memoize = new MemoizeCache($test);

	}
	/**
	 * @covers \Mimic\Functional\MemoizeCache::__construct
	 */
	public function testCallbackPropertyMatchesOriginal() {
		$expected = function() { return true; };
		$memoize = new MemoizeCache($expected);
		$reflect = new \ReflectionClass($memoize);
		$property = $reflect->getProperty('_callback');
		$property->setAccessible(true);
		$actual = $property->getValue($memoize);
		$this->assertSame($expected, $actual);
	}

	/**
	 * @covers \Mimic\Functional\MemoizeCache::__invoke
	 */
	public function testCallbackArguments() {
		$memoize = $this->memoize;
		$this->assertEquals(array(), $memoize());
		$this->assertEquals(1, $this->executed[\json_encode(array())]);

		$this->assertEquals(array(), $memoize());
		$this->assertEquals(1, $this->executed[\json_encode(array())]);

		$this->assertEquals(array(1), $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode(array(1))]);

		$this->assertEquals(array(1), $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode(array(1))]);

		$this->assertEquals(array(), $memoize());
		$this->assertEquals(1, $this->executed[\json_encode(array())]);

		$this->assertEquals(array(1, 2), $memoize(1, 2));
		$this->assertEquals(1, $this->executed[\json_encode(array(1, 2))]);

		$this->assertEquals(array(1, 2), $memoize(1, 2));
		$this->assertEquals(1, $this->executed[\json_encode(array(1, 2))]);
	}

	/**
	 * @covers \Mimic\Functional\MemoizeCache::__invoke
	 */
	public function testCallParametersOnlyExecutesOnce_SameArgNum() {
		$memoize = $this->memoize;

		$expected = array();
		$this->assertEquals($expected, $memoize());
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$this->assertEquals($expected, $memoize());
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$expected = array(1);
		$this->assertEquals($expected, $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$this->assertEquals($expected, $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$expected = array(2);
		$this->assertEquals($expected, $memoize(2));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$this->assertEquals($expected, $memoize(2));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);
	}

	/**
	 * @covers \Mimic\Functional\MemoizeCache::clean
	 */
	public function testClean1Args() {
		$memoize = $this->memoize;

		$expected = array(1);
		$this->assertEquals($expected, $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$memoize->clean(1);

		$this->assertEquals($expected, $memoize(1));
		$this->assertEquals(2, $this->executed[\json_encode($expected)]);
	}

	/**
	 * @covers \Mimic\Functional\MemoizeCache::clean
	 */
	public function testClean2Args() {
		$memoize = $this->memoize;

		$expected = array(1, 2);
		$this->assertEquals($expected, $memoize(1, 2));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$memoize->clean(2, 2);

		$this->assertEquals($expected, $memoize(1, 2));
		$this->assertEquals(1, $this->executed[\json_encode($expected)]);

		$memoize->clean(1, 2);

		$this->assertEquals($expected, $memoize(1, 2));
		$this->assertEquals(2, $this->executed[\json_encode($expected)]);
	}

	/**
	 * @covers \Mimic\Functional\MemoizeCache::clear
	 */
	public function testClear() {
		$memoize = $this->memoize;

		$this->assertEquals(array(1, 2), $memoize(1, 2));
		$this->assertEquals(1, $this->executed[\json_encode(array(1, 2))]);

		$this->assertEquals(array(2, 2), $memoize(2, 2));
		$this->assertEquals(1, $this->executed[\json_encode(array(2, 2))]);

		$this->assertEquals(array(1), $memoize(1));
		$this->assertEquals(1, $this->executed[\json_encode(array(1))]);

		$memoize->clear();

		$this->assertEquals(array(1, 2), $memoize(1, 2));
		$this->assertEquals(2, $this->executed[\json_encode(array(1, 2))]);

		$this->assertEquals(array(2, 2), $memoize(2, 2));
		$this->assertEquals(2, $this->executed[\json_encode(array(2, 2))]);

		$this->assertEquals(array(1), $memoize(1));
		$this->assertEquals(2, $this->executed[\json_encode(array(1))]);
	}
}
