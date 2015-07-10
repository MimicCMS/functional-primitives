<?php

namespace Mimic\Test\Fake;

class Put {
	public $one;
	public $two;

	protected $_internal = array();

	public function __get($name) {
		return $this->_internal[$name];
	}

	public function __set($name, $value) {
		$this->_internal[$name] = $value;
	}
}
