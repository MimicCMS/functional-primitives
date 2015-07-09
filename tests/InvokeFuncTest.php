<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for invoke Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testDummy_Invoke_exists() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$expected = array(true, true);
		$actual = F\invoke($collection, 'exists');
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testDummy_Invoke_with() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$arguments = array(1, 2, 3);
		$expected = array($arguments, $arguments);
		$actual = F\invoke($collection, 'with', $arguments);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testMethodDoesNotExist() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$expected = array(null, null);
		$actual = F\invoke($collection, '__doesnotexist__');
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invoke
	 */
	public function testClassMethod() {
		$collection = array('\Mimic\Test\Dummy\Invoke', '\Mimic\Test\Dummy\Invoke');
		$expected = array(true, true);
		$actual = F\invoke($collection, 'method');
		$this->assertEquals($expected, $actual);
	}
}
