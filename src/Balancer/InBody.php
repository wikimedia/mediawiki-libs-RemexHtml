<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Attributes;

class InBody extends InsertionMode {

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
	}
}
