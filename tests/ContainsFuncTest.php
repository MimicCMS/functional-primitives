<?php

use Mimic\Functional as F;

/**
 * Unit Test for contains Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class ContainsFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		$floats = array(0.1, 0.3, 1.5, 2.5, 3.5, 4.0);
		$stringFloats = array('0.1', '0.3', '1.5', '2.5', '3.5', '4.0');

		$ints = array(0, 1, 2, 3, 4);
		$stringInts = array('0', '1', '2', '3', '4');

		return array(
			array(false, true, 5,    $ints),
			array(true,  false, '4', $ints),
			array(true,  true, 4,    $ints),
			array(false, true, '4',  $ints),
			array(true,  true, 1.5,  $floats),
			array(true,  true, 0.1,  $floats),
			array(false,  true, (0.1 + 0.1 + 0.1), $floats),
			array(true,  false, '0.3', $floats),
			array(true,  true, '4',    $stringInts),
			array(true,  false, '4',   $stringInts),
			array(false, false, '5',   $stringInts),
			array(false, true, '5',    $stringInts),
			array(true,  true, 1.5,    $floats),
			array(true,  true, 0.1,    $floats),
			array(true,  true, '0.3', $stringFloats),
			array(false,  true, '0.56', $stringFloats),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\contains
	 */
	public function testResults($result, $strict, $value, $collection) {
		$this->assertEquals($result, F\contains($collection, $value, $strict));
	}
}
