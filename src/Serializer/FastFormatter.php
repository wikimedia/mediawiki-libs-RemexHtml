<?php

namespace RemexHtml\Serializer;
use RemexHtml\Tokenizer\Attributes;

/**
 * A formatter suitable for pre-sanitized input with ignoreEntities enabled
 * in the Tokenizer.
 */
class FastFormatter implements Formatter {
	function __construct( $options = [] ) {
	}

	function startDocument( $fragmentNamespace, $fragmentName ) {
		if ( $fragmentNamespace === null ) {
			return "<!DOCTYPE html>\n";
		} else {
			return '';
		}
	}

	function doctype( $name, $public, $system ) {
	}

	function characters( $text, $start, $length ) {
		return substr( $text, $start, $length );
	}

	function element( $namespace, $name, Attributes $attrs, $contents ) {
		$ret = "<$name";
		foreach ( $attrs->getValues() as $attrName => $value ) {
			$ret .= " $attrName=\"$value\"";
		}
		if ( $contents === null ) {
			$ret .= "/>";
		} else {
			$ret .= ">$contents</$name>";
		}
		return $ret;
	}

	function comment( $text ) {
		return "<!--$text-->";
	}
}
