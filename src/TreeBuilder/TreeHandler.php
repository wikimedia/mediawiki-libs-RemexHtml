<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

interface TreeHandler {
	function startDocument();

	function endDocument( $pos );

	function characters( $parent, $refNode, $text, $start, $length, $sourceStart, $sourceLength );

	/**
	 * Insert an element
	 * @param Element|null @parent The parent element, or null if there isn't one
	 * @param Element|null $refNode Insert before this sibling, or null to
	 *   append to the end of the child node list.
	 * @param Element $element An object containing information about the new
	 *   element. The same object will be used for $parent and $refNode in
	 *   other calls as appropriate. The handler can set $element->userData to
	 *   attach a suitable DOM object to identify the mutation target in
	 *   subsequent calls.
	 * @param bool $void True if this is a void element which cannot
	 *   have any children appended to it. This depends only on the node name,
	 *   it is independent of the input syntax.
	 * @param integer $sourceStart The input position
	 * @param integer $sourceLength The length of the input which is consumed
	 */
	function insertElement( $parent, $refNode, Element $element, $void,
		$sourceStart, $sourceLength );

	function endTag( Element $element, $sourceStart, $sourceLength ) ;

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) ;

	function comment( $parent, $refNode, $text, $sourceStart, $sourceLength ) ;

	function error( $text, $pos ) ;

	function mergeAttributes( Element $element, Attributes $attrs, $sourceStart );

	function reparentNode( Element $element, Element $newParent, $sourceStart );

	function removeNode( Element $element, $sourceStart );

	function reparentChildren( Element $element, Element $newParent );

}
