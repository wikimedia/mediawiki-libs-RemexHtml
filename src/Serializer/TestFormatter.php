<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\HTMLData;

class TestFormatter implements Formatter {
	function startDocument( $fragmentNamespace, $fragmentName ) {
		return '';
	}

	function doctype( $name, $public, $system ) {
		$ret = "<!DOCTYPE $name";
		if ( $public !== '' || $system !== '' ) {
			$ret .= " \"$public\" \"$system\"";
		}
		$ret .= ">\n";
		return $ret;
	}

	function characters( $text, $start, $length ) {
		return '"' .
			str_replace( "\n", "<EOL>", substr( $text, $start, $length ) ) .
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
		$sortedAttrs = $attrs->getObjects();
		ksort( $sortedAttrs, SORT_STRING );
		foreach ( $sortedAttrs as $attrName => $attr ) {
			if ( $attr->prefix !== null ) {
				$ret .= "  {$attr->prefix} {$attr->localName}=\"{$attr->value}\"\n";
			} else {
				$ret .= "  $attrName=\"{$attr->value}\"\n";
			}
		}
		if ( $contents !== null && $contents !== '' ) {
			$contents = preg_replace( '/^/m', '  ', $contents );
		} else {
			$contents = '';
		}
		if ( $namespace === HTMLData::NS_HTML && $name === 'template' ) {
			if ( $contents === '' ) {
				$contents = "  content\n";
			} else {
				$contents = "  content\n" . preg_replace( '/^/m', '  ', $contents );
			}
		}
		$ret .= $contents;
		return $ret;
	}

	function comment( $text ) {
		return "<!-- $text -->\n";
	}
}
