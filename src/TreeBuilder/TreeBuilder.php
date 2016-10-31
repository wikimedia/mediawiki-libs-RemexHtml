<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class TreeBuilder {
	const NO_QUIRKS = 0;
	const LIMITED_QUIRKS = 1;
	const QUIRKS = 2;

	public $quirks = self::NO_QUIRKS;
	public $isIframeSrcdoc;
	public $scriptingFlag;
	public $framesetOK = true;
	public $hasBody = false;

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
	}

	function insert( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
	}

	function insertForeign( $ns, $name, Attributes $attrs, $selfClose,
		$sourceStart, $sourceLength
	) {
		if ( $attrs->count() ) {
			$balancerAttrs = new LazyAttributes( $attrs, function( $attrs ) {
				return $this->adjustAttributes( $attrs );
			} );
		}
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

	function stackHas( $name ) {
	}

	function addHtmlAttrs( Attributes $attrs ) {
	}

	function addBodyAttrs( Attributes $attrs ) {
	}

	function closePInButtonScope() {
	}

	function isFormIgnored() {
		// If the form element pointer is not null, and there is no 
		// template element on the stack of open elements, then this
		// is a parse error; ignore the token.
	}

	function insertForm( Attributes $attrs, $sourceStart, $sourceLength ) {
		// Insert an HTML element for a "form" start tag token, and, if there
		// is no template element on the stack of open elements, set the form
		// element pointer to point to the element created.
	}

	function reconstructAFE( $sourceStart ) {
	}

	function adoptionAgency( $subject, $sourceStart, $sourceLength ) {
		
	}
}
