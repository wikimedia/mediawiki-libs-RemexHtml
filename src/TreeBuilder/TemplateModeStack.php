<?php

namespace Wikimedia\RemexHtml\TreeBuilder;

class TemplateModeStack {
	public $current;
	private $nonCurrentModes = [];

	public function push( $mode ) {
		$this->nonCurrentModes[] = $this->current;
		$this->current = $mode;
	}

	public function pop() {
		$this->current = array_pop( $this->nonCurrentModes );
	}

	public function isEmpty() {
		return $this->current === null;
	}
}
