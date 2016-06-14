<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

interface BalancerHandler {
	function startDocument();

	function endDocument();

	function characters( $parent, $text, $start, $length, $sourceStart, $sourceLength );

	function startTag( $parent, $prefix, $name, Attributes $attrs, $selfClose,
		$sourceStart, $sourceLength );

	function endTag( $node, $prefix, $name, $sourceStart, $sourceLength ) ;

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) ;

	function comment( $parent, $text, $sourceStart, $sourceLength ) ;

	function error( $text, $pos ) ;

	function mergeAttributes( $node, $prefix, $name, Attributes $attrs, $sourceStart );

	function removeBody( $sourceStart );

	function reparentNode( $parent, $target, $prefix, $name, Attributes $attrs, $sourceStart );

	function reparentChildren( $target, $prefix, $name, Attributes $attrs, $sourceStart );
}
