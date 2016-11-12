<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Attributes;

class AfterAfterFrameset extends InsertionMode {
	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
	}

	public function endDocument( $pos ) {
	}
}
