<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\HTMLData;

class TestFormatter implements Formatter {
	function startDocument() {
		return '';
	}

	function doctype( $name, $public, $system ) {
		$ret = "<!DOCTYPE $name";
		if ( $public !== '' || $system !== '' ) {
			$ret .= " \"$public\" \"$system\"";
		}
		$ret .= '>';
		return $ret;
	}

	function characters( $text, $start, $length ) {
		return '"' . 
			str_replace( "\n", "\\n", substr( $text, $start, $length ) ) .
			"\"\n";
	}

	function element( $namespace, $name, Attributes $attrs, $contents ) {
		if ( $namespace === HTMLData::NS_HTML ) {
			$tagName = $name;
		} elseif ( $namespace === HTMLData::NS_SVG ) {
			$tagName = "svg $name";
		} elseif ( $namespace === HTMLData::NS_MATHML ) {
			$tagName = "math $name";
		} else {
			$tagName = $name;
		}
		$ret = "<$tagName>\n";
		$sortedAttrs = $attrs->getArrayCopy();
		ksort( $sortedAttrs );
		foreach ( $sortedAttrs as $name => $value ) {
			$ret .= "  $name=\"$value\"";
		}
		if ( $contents !== null && $contents !== '' ) {
			$contents = preg_replace( '/^/m', '  ', $contents );
		} else {
			$contents = '';
		}
		if ( $namespace === HTMLData::NS_HTML && $name === 'template' ) {
			$contents = "content\n" . preg_replace( '/^/m', '  ', $contents );
		}
		$ret .= $contents;
		return $ret;
	}

	function comment( $text ) {
		return "<!--$text-->\n";
	}
}
