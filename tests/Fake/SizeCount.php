<?php

namespace Mimic\Test\Fake;

use Countable;

class SizeCount implements Countable {

	public $limit = 0;

	public function __construct($limit) {
		$this->limit = $limit;
	}

	public function count() {
		return $this->limit;
	}
}
