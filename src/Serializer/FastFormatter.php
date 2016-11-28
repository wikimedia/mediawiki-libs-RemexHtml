<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class FastFormatter implements Formatter {
	function __construct( $options = [] ) {
	}

	function startDocument() {
		return "<!DOCTYPE html>\n";
	}

	function characters( $text, $start, $length ) {
		return substr( $text, $start, $length );
	}

	function element( $namespace, $name, Attributes $attrs, $contents ) {
		$ret = "<$name";
		foreach ( $attrs->getArrayCopy() as $name => $value ) {
			$ret .= " $name=\"$value\"";
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
