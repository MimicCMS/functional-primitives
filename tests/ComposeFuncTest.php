<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for compose Mimic library function.
 *
 * @since 0.1.0
 */
class ComposeFuncTest extends PHPUnit_Framework_TestCase {
	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testEmptyDoesNothing() {
		$callback = F\compose();
		$this->assertEquals(null, $callback());
		$this->assertEquals(null, $callback(array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testArraySumJSONEncode() {
		$expected = json_encode(array_sum(array(1, 2, 3)));
		$callback = F\compose('array_sum', 'json_encode');
		$this->assertEquals($expected, $callback(array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testDataSerialized() {
		$data = function() {
			return func_get_args();
		};
		$expected = serialize(array(1, 2, 3));
		$callback = F\compose($data, 'serialize');
		$this->assertEquals($expected, $callback(1, 2, 3));
	}

	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testArraySumJSONEncodeJSONDecode() {
		$expected = json_encode(array_sum(array(1, 2, 3)));
		$callback = F\compose('array_sum', 'json_encode');
		$this->assertEquals($expected, $callback(array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testDataSerializedUnserialize() {
		$data = function() {
			return func_get_args();
		};
		$expected = unserialize(serialize(array(1, 2, 3)));
		$callback = F\compose($data, 'serialize', 'unserialize');
		$this->assertEquals($expected, $callback(1, 2, 3));
	}

	/**
	 * @covers ::Mimic\Functional\pipeline
	 */
	public function testArraySumJSONEncode_pipeline() {
		$expected = json_encode(array_sum(array(1, 2, 3)));
		$callback = F\pipeline('json_encode', 'array_sum');
		$this->assertEquals($expected, $callback(array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\compose
	 */
	public function testDataSerialized_pipeline() {
		$data = function() {
			return func_get_args();
		};
		$expected = serialize(array(1, 2, 3));
		$callback = F\pipeline('serialize', $data);
		$this->assertEquals($expected, $callback(1, 2, 3));
	}

	/**
	 * @covers ::Mimic\Functional\pipeline
	 */
	public function testArraySumJSONEncodeJSONDecode_pipeline() {
		$expected = json_encode(array_sum(array(1, 2, 3)));
		$callback = F\pipeline('json_encode', 'array_sum');
		$this->assertEquals($expected, $callback(array(1, 2, 3)));
	}

	/**
	 * @covers ::Mimic\Functional\pipeline
	 */
	public function testDataSerializedUnserialize_pipeline() {
		$data = function() {
			return func_get_args();
		};
		$expected = unserialize(serialize(array(1, 2, 3)));
		$callback = F\pipeline('unserialize', 'serialize', $data);
		$this->assertEquals($expected, $callback(1, 2, 3));
	}
}
