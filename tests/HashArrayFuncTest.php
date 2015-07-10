<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for hash_array Mimic library function.
 *
 * @since 0.1.0
 */
class HashArrayFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$callback = function() { return true; };
		$callbackName = get_class($callback);
		$callbackRef = spl_object_hash($callback);
		$invokeTrue = 'Mimic\\\\\\\\Test\\\\\\\\Stub\\\\\\\\InvokeTrue';
		$invokeFalse = 'Mimic\\\\\\\\Test\\\\\\\\Stub\\\\\\\\InvokeFalse';
		return array(
			array(
				array(),
				'/\[\]/'
			),
			array(
				array(1, 2, 3),
				'/\[1,2,3\]/'
			),
			array(
				array(new Stub\InvokeTrue, new Stub\InvokeFalse, 1, 2),
				'/\["'.$invokeTrue.':[0-9a-zA-Z]+","'.$invokeFalse.':[0-9a-zA-Z]+",1,2\]/'
			),
			array(
				array(1, 2, new Stub\InvokeTrue, new Stub\InvokeFalse),
				'/\[1,2,"'.$invokeTrue.':[0-9a-zA-Z]+","'.$invokeFalse.':[0-9a-zA-Z]+"\]/'
			),
			array(
				array($callback),
				'/\["'.$callbackName.':'.$callbackRef.'"\]/'
			),
			array(
				array(1, $callback),
				'/\[1,"'.$callbackName.':'.$callbackRef.'"\]/'
			),
			array(
				array(0, 1, $callback),
				'/\[0,1,"'.$callbackName.':'.$callbackRef.'"\]/'
			),
			array(
				array(0, 1, $callback, new Stub\InvokeTrue),
				'/\[0,1,"'.$callbackName.':'.$callbackRef.'","'.$invokeTrue.':[0-9a-zA-Z]+"\]/'
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\hash_array
	 */
	public function testResults($args, $expected) {
		$this->assertRegExp($expected, F\hash_array($args));
	}
}
