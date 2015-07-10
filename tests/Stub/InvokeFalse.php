<?php

namespace Mimic\Test\Stub;

class Invoke {
	public function exists() {
		return false;
	}

	public function with() {
		return array_reverse(func_get_args());
	}

	public static function method() {
		return false;
	}
}
