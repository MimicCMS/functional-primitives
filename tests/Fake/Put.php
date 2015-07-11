<?php

namespace Mimic\Test\Fake;

class Put {
	public $one;
	public $two;

	public $internal = array();

	public function __isset($name) {
		return array_key_exists($name, $this->internal);
	}

	public function __get($name) {
		return $this->internal[$name];
	}

	public function __set($name, $value) {
		$this->internal[$name] = $value;
	}
}
