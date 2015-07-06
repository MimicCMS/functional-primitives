<?php

namespace Mimic\Test;

use PHPUnit_Framework_TestCase;
use Mimic\Functional as F;

/**
 * Unit Test for dropFirst Mimic library function.
 *
 * @since 0.1.0
 */
class WrapFuncTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers ::Mimic\Functional\wrap
	 */
	public function testIsClosure_UsingFileExistsFunction() {
		$callback = F\wrap('file_exists');
		$this->assertTrue($callback instanceof \Closure);
	}

	/**
	 * @covers ::Mimic\Functional\wrap
	 */
	public function testFileExistsFunction_FileDoesNotExist() {
		$callback = F\wrap('file_exists', __DIR__ . '/nonexistantfile.doesnotexist');
		$this->assertFalse($callback());
	}

	/**
	 * @covers ::Mimic\Functional\wrap
	 */
	public function testFileExistsFunction_DirectoryExists() {
		$callback = F\wrap('file_exists', __DIR__);
		$this->assertTrue($callback());
	}

	/**
	 * @covers ::Mimic\Functional\wrap
	 */
	public function testFileExistsFunction_FileExists() {
		$callback = F\wrap('file_exists', __FILE__);
		$this->assertTrue($callback());
	}
}
