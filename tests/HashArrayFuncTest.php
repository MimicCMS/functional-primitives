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
		return array(
			array(
				array(),
				'[]'
			),
			array(
				array(1, 2, 3),
				'[1,2,3]'
			),
			array(
				array(new Stub\InvokeTrue, new Stub\InvokeFalse, 1, 2),
				'["Mimic\\Test\\Stub\\InvokeTrue:000000005c48c5350000000052ff7dbb","Mimic\\Test\\Stub\\InvokeFalse:000000005c48c5320000000052ff7dbb",1,2]'
			),
			array(
				array(1, 2, new Stub\InvokeTrue, new Stub\InvokeFalse),
				'[1,2,"Mimic\\Test\\Stub\\InvokeTrue:000000005c48c5330000000052ff7dbb","Mimic\\Test\\Stub\\InvokeFalse:000000005c48c5300000000052ff7dbb"]'
			),
			array(
				array($callback),
				'["Closure:000000005c48c5340000000052facefb"]'
			),
			array(
				array(1, $callback),
				'[1,"Closure:000000005c48c5340000000052facefb"]'
			),
			array(
				array(0, 1, $callback),
				'[0,1,"Closure:000000005c48c5340000000052facefb"]'
			),
			array(
				array(0, 1, $callback, new Stub\InvokeTrue),
				'[0,1,"Closure:000000005c48c5340000000052facefb","Mimic\\Test\\Stub\\InvokeTrue:000000005c48c5310000000052ff7dbb"]'
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\hash_array
	 */
	public function testResults($args, $expected) {
		$this->assertEquals($expected, F\hash_array($args));
	}
}
