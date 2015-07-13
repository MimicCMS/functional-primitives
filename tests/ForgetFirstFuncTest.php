<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

use ArrayIterator;

/**
 * Unit Test for forgetFirst Mimic library function.
 *
 * @since 0.1.0
 */
class ForgetFirstFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$instance = new ArrayIterator(array(1, 2, 3));
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(2, 3)),
			array($instance, $instance, array(2, 3)),
			array(array('something', 'else'), array('something', 'else'), array('else')),
			array(array('else'), array('else'), array()),
			array(array(), array(), array()),
		);
	}

	public function dataProvider_removeSecond() {
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(1, 2 => 3)),
			array(new ArrayIterator(array(1, 2, 3)), array(1, 2, 3), array(1, 2 => 3)),
			array(array('something', 'else', 'hello', 'world'), array('something', 'else', 'hello', 'world'), array('something', 2 => 'hello', 3 => 'world')),
			array(array('else'), array('else'), array('else')),
			array(array(), array(), array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetFirst
	 */
	public function testResults($collection, $check, $expected) {
		$this->assertEquals($expected, F\forgetFirst($collection));
		$this->assertSame($check, $collection, 'collection has changed');
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetFirst
	 */
	public function testResultWithCallbacks_keepAll($collection) {
		$self = $this;
		$callback = function($element, $index, $array) use ($self, $collection) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			return false;
		};
		$this->assertEquals($collection, F\forgetFirst($collection, $callback));
	}

	/**
	 * @dataProvider dataProvider_removeSecond
	 * @covers ::Mimic\Functional\forgetFirst
	 */
	public function testResultWithCallbacks_removeSecond($collection, $check, $expected) {
		$self = $this;
		$at = 0;
		$callback = function($element, $index, $array) use (&$at, $self, $collection) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			$at += 1;
			return $at === 2;
		};
		$this->assertEquals($expected, F\forgetFirst($collection, $callback));
		$this->assertSame($check, $collection, 'collection has changed');
	}
}
