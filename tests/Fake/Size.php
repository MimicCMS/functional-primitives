<?php

namespace Mimic\Test\Fake;

use Iterator;

class Size implements Iterator {
	public $at = 0;

	public $limit = 0;

	public function __construct($limit) {
		$this->limit = $limit;
	}

	public function current() {
		return $this->at;
	}

	public function key() {
		return $this->at;
	}

	public function next() {
		$this->at += 1;
	}

	public function rewind() {
		$this->at = 0;
	}

	public function valid() {
		return $this->at < $this->limit;
	}
}
