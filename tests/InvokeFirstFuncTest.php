<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class InvokeFirstFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testDummy_Invoke_exists() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$expected = true;
		$actual = F\invokeFirst($collection, 'exists');
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testDummy_Invoke_with() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$expected = array(1, 2, 3);
		$actual = F\invokeFirst($collection, 'with', $expected);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testMethodDoesNotExist() {
		$collection = array(new Dummy\Invoke, new Dummy\Invoke);
		$expected = null;
		$actual = F\invokeFirst($collection, '__doesnotexist__');
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @covers ::Mimic\Functional\invokeFirst
	 */
	public function testClassMethod() {
		$collection = array('\Mimic\Test\Dummy\Invoke', '\Mimic\Test\Dummy\Invoke');
		$expected = true;
		$actual = F\invokeFirst($collection, 'method');
		$this->assertEquals($expected, $actual);
	}
}
