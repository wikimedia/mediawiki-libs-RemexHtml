<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class Balancer {
	const NO_QUIRKS = 0;
	const LIMITED_QUIRKS = 1;
	const QUIRKS = 2;

	public $isIframeSrcdoc;
	public $scriptingFlag;

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
	}

	function comment( $text, $sourceStart, $sourceLength ) {
	}

	function error( $text, $pos ) {
	}

	function insertAfeMarker() {
	}

	function framesetNotOK() {
	}

	function pushTemplateMode( $mode ) {
	}

	function endTemplateTag( $sourceStart, $sourceEnd ) {
	}
}
