<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for put Mimic library function.
 *
 * @since 0.1.0
 */
class PutFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testArray() {
		$collection = array();

		$actual1 = F\put($collection, 'test', 'value', false);
		$this->assertEquals(array('test' => 'value'), $actual1);

		$actual2 = F\put($actual1, 'test', 'something', false);
		$this->assertEquals(array('test' => 'value'), $actual2);

		$actual3 = F\put($actual2, 'test', 'something', true);
		$this->assertEquals(array('test' => 'something'), $actual3);

		$actual4 = F\put($actual3, 'something', 'else', false);
		$this->assertEquals(array('test' => 'something', 'something' => 'else'), $actual4);

		$actual5 = F\put($actual4, 'hello', 'world', false);
		$this->assertEquals(array('test' => 'something', 'something' => 'else', 'hello' => 'world'), $actual5);
	}

	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testStandardObject() {
		$collection = (object) array();

		$actual1 = F\put($collection, 'test', 'value', false);
		$this->assertEquals((object) array('test' => 'value'), $actual1);
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($actual1, 'test', 'something', false);
		$this->assertEquals((object) array('test' => 'value'), $actual2);
		$this->assertNotSame($actual1, $actual2);

		$actual3 = F\put($actual2, 'test', 'something', true);
		$this->assertEquals((object) array('test' => 'something'), $actual3);
		$this->assertNotSame($actual2, $actual3);

		$actual4 = F\put($actual3, 'something', 'else', false);
		$this->assertEquals((object) array('test' => 'something', 'something' => 'else'), $actual4);
		$this->assertNotSame($actual3, $actual4);

		$actual5 = F\put($actual4, 'hello', 'world', false);
		$this->assertEquals((object) array('test' => 'something', 'something' => 'else', 'hello' => 'world'), $actual5);
		$this->assertNotSame($actual4, $actual5);
	}

	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testPutObject_one() {
		$collection = new Fake\Put;

		$expected1 = new Fake\Put;
		$expected1->one = 1;

		$actual1 = F\put($collection, 'one', 1, false);
		$this->assertEquals($expected1, $actual1);
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($collection, 'one', 2, false);
		$this->assertEquals($expected1, $actual2);
		$this->assertNotSame($collection, $actual2);

		$expected2 = clone $expected1;
		$expected2->one = 2;
		$actual3 = F\put($collection, 'one', 2, true);
		$this->assertEquals($expected2, $actual3);
		$this->assertNotSame($collection, $actual3);
	}

	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testPutObject_two() {
		$collection = new Fake\Put;

		$expected1 = new Fake\Put;
		$expected1->two = 2;

		$actual1 = F\put($collection, 'two', 2, false);
		$this->assertEquals($expected1, $actual1);
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($collection, 'two', 3, false);
		$this->assertEquals($expected1, $actual2);
		$this->assertNotSame($collection, $actual2);

		$expected2 = clone $expected1;
		$expected2->two = 3;
		$actual3 = F\put($collection, 'two', 3, true);
		$this->assertEquals($expected2, $actual3);
		$this->assertNotSame($collection, $actual3);
	}

	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testPutObject_dynamic() {
		$collection = new Fake\Put;

		$expected1 = new Fake\Put;
		$expected1->something = 'else';

		$actual1 = F\put($collection, 'something', 'else', false);
		$this->assertEquals($expected1, $actual1);
		$this->assertNotSame($collection, $actual1);

		$expected2 = new Fake\Put;
		$expected2->something = 'else';
		$expected2->hello = 'world';

		$actual2 = F\put($collection, 'hello', 'world', false);
		$this->assertEquals($expected1, $actual2);
		$this->assertNotSame($collection, $actual2);
	}
}
