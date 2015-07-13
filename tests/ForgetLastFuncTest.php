<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

use ArrayIterator;

/**
 * Unit Test for forgetLast Mimic library function.
 *
 * @since 0.1.0
 */
class ForgetLastFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$instance = new ArrayIterator(array(1, 2, 3));
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(1, 2)),
			array($instance, $instance, array(1, 2)),
			array(array('something', 'else'), array('something', 'else'), array('something')),
			array(array('else'), array('else'), array()),
			array(array(), array(), array()),
		);
	}

	public function dataProvider_removeSecond() {
		$instance = new ArrayIterator(array(1, 2, 3));
		return array(
			array(array(1, 2, 3), array(1, 2, 3), array(1, 2 => 3)),
			array($instance, $instance, array(1, 2 => 3)),
			array(array('something', 'else', 'hello', 'world'), array('something', 'else', 'hello', 'world'), array('something', 1 => 'else', 3 => 'world')),
			array(array('else'), array('else'), array('else')),
			array(array(), array(), array()),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetLast
	 */
	public function testResults($collection, $check, $expected) {
		$this->assertEquals($expected, F\forgetLast($collection));
		$this->assertSame($check, $collection, 'collection has changed');
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\forgetLast
	 */
	public function testResultWithCallbacks_keepAll($collection) {
		$self = $this;
		$callback = function($element, $index, $array) use ($self, $collection) {
			$self->assertSame($collection, $array, 'callback collection is different from given');
			$self->assertEquals($collection[$index], $element, 'element does not match element with index at given collection');
			return false;
		};
		if ($collection instanceof Traversable) {
			$this->assertEquals(\array_to_iterator($collection), F\forgetLast($collection, $callback));
		}
		else {
			$this->assertEquals($collection, F\forgetLast($collection, $callback));
		}
	}

	/**
	 * @dataProvider dataProvider_removeSecond
	 * @covers ::Mimic\Functional\forgetLast
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
		$this->assertEquals($expected, F\forgetLast($collection, $callback));
		$this->assertSame($check, $collection, 'collection has changed');
	}
}
