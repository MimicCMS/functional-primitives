<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for apply Mimic library function.
 *
 * @since 0.1.0
 */
class ApplyFuncTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers ::Mimic\Functional\apply
	 */
	public function testApplyExecutesClosure() {
		$this->assertTrue(F\apply(function() {return true; }));
	}

	/**
	 * @covers ::Mimic\Functional\apply
	 */
	public function testFileExistsFunction_FileDoesNotExist() {
		$this->assertFalse(F\apply(
			F\wrap('file_exists', __DIR__ . '/nonexistantfile.doesnotexist')
		));
	}

	/**
	 * @covers ::Mimic\Functional\apply
	 */
	public function testFileExistsFunction_DirectoryExists() {
		$this->assertTrue(F\apply(F\wrap('file_exists', __DIR__)));
	}

	/**
	 * @covers ::Mimic\Functional\apply
	 */
	public function testFileExistsFunction_FileExists() {
		$this->assertTrue(F\apply(F\wrap('file_exists', __FILE__)));
	}
}
