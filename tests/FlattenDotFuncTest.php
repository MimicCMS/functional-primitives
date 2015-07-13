<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for flattenDot Mimic library function.
 *
 * @since 0.1.0
 *
 * @todo Need to use QuickTest library.
 */
class FlattenDotFuncTest extends PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return array(
			array(
				array('0' => 1, '1' => 2, '2' => 3, '3.0' => 1, '3.1' => 2, '3.2' => 3),
				array(1, 2, 3, array(1, 2, 3))
			),
			array(
				array(
					'0' => 1, '1' => 2, '2' => 3,
					'3.0' => 4, '3.1' => 5, '3.2' => 6,
					'4.0.0' => 7, '4.0.1' => 8, '4.0.2' => 9),
				array(1, 2, 3, array(4, 5, 6), array(array(7,8, 9)))
			),
			array(
				array(
					'index1' => 1,
					'index2' => 2,
					'index3' => 3,
					'index4.something1' => 4,
					'index4.something2' => 5,
					'index4.something3' => 6,
					'index5.something4.else1' => 7,
					'index5.something4.else2' => 8,
					'index5.something4.else3' => 9,
				),
				array(
					'index1' => 1,
					'index2' => 2,
					'index3' => 3,
					'index4' => array(
						'something1' => 4,
						'something2' => 5,
						'something3' => 6,
					),
					'index5' => array(
						'something4' => array(
							'else1' => 7,
							'else2' => 8,
							'else3' => 9,
						)
					)
				)
			),
		);
	}

	/**
	 * @dataProvider dataProvider
	 * @covers ::Mimic\Functional\flattenDot
	 */
	public function testResults($expected, $collection) {
		$this->assertEquals($expected, F\flattenDot($collection));
	}
}
