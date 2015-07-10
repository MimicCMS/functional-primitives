<?php

namespace Mimic\Test\Stub;

class InvokeTrue {
	public function exists() {
		return true;
	}

	public function with() {
		return func_get_args();
	}

	public static function method() {
		return true;
	}
}
