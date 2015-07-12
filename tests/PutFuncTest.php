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

		$expected1 = (object) array('test' => 'value');
		$expected2 = (object) array('test' => 'something');
		$expected3 = (object) array('test' => 'something', 'something' => 'else');
		$expected4 = (object) array('test' => 'something', 'something' => 'else', 'hello' => 'world');

		$actual1 = F\put($collection, 'test', 'value', false);
		$this->assertEquals($expected1, $actual1, 'Actual 1');
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($actual1, 'test', 'something', false);
		$this->assertEquals($expected1, $actual2, 'Actual 2');
		$this->assertNotSame($actual1, $actual2);

		$actual3 = F\put($actual2, 'test', 'something', true);
		$this->assertEquals($expected2, $actual3, 'Actual 3');
		$this->assertNotSame($actual2, $actual3);

		$actual4 = F\put($actual3, 'something', 'else', false);
		$this->assertEquals($expected3, $actual4, 'Actual 4');
		$this->assertNotSame($actual3, $actual4);

		$actual5 = F\put($actual4, 'hello', 'world', false);
		$this->assertEquals($expected4, $actual5, 'Actual 5');
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
		$this->assertEquals($expected1, $actual1, 'Actual 1');
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($actual1, 'one', 2, false);
		$this->assertEquals($expected1, $actual2, 'Actual 2');
		$this->assertNotSame($collection, $actual2);

		$expected2 = clone $expected1;
		$expected2->one = 2;

		$actual3 = F\put($actual1, 'one', 2, true);
		$this->assertEquals($expected2, $actual3, 'Actual 3');
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
		$this->assertEquals($expected1, $actual1, 'Actual 1');
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($actual1, 'two', 3, false);
		$this->assertEquals($expected1, $actual2, 'Actual 2');
		$this->assertNotSame($collection, $actual2);

		$expected2 = clone $expected1;
		$expected2->two = 3;

		$actual3 = F\put($actual1, 'two', 3, true);
		$this->assertEquals($expected2, $actual3, 'Actual 3');
		$this->assertNotSame($collection, $actual3);
	}

	/**
	 * @covers ::Mimic\Functional\put
	 */
	public function testPutObject_dynamic() {
		$collection = new Fake\Put;

		$expected1 = new Fake\Put;
		$expected1->something = 'else';

		$expected2 = new Fake\Put;
		$expected2->something = 'else';
		$expected2->hello = 'world';

		$actual1 = F\put($collection, 'something', 'else', false);
		$this->assertEquals($expected1, $actual1, 'Actual 1');
		$this->assertNotSame($collection, $actual1);

		$actual2 = F\put($actual1, 'hello', 'world', false);
		$this->assertEquals($expected2, $actual2, 'Actual 2');
		$this->assertNotSame($collection, $actual2);

		$this->assertFalse(property_exists($actual2, 'something'), 'something property exists');
		$this->assertFalse(property_exists($actual2, 'hello'), 'hello property exists');
		$this->assertTrue(isset($actual2->something), 'something property isset');
		$this->assertTrue(isset($actual2->hello), 'hello property isset');

		$actual3 = F\put($actual2, 'something', 'something', false);
		$this->assertEquals($expected2, $actual3, 'Actual 3');
		$this->assertNotSame($collection, $actual3);

		$actual4 = F\put($actual2, 'hello', 'hello', false);
		$this->assertEquals($expected2, $actual4, 'Actual 4');
		$this->assertNotSame($collection, $actual4);
	}
}
