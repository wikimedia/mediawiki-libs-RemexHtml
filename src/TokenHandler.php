<?php

namespace Wikimedia\RemexHtml;

interface TokenHandler {
	function startDocument();
	function endDocument();
	function error( $text, $pos );
	function characters( $text, $start, $length, $sourceStart, $sourceLength );
	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength );
	function endTag( $name, $sourceStart, $sourceLength );
	function doctype( $name, $public, $system, $quirks );
	function comment( $text, $sourceStart, $sourceLength );
}
