<?php

namespace RemexHtml\Serializer;
use RemexHtml\Tokenizer\Attributes;

class XhtmlFormatter implements Formatter {
	public function startDocument( $fragmentNamespace, $fragmentName ) {
		return "<!DOCTYPE html>\n";
	}

	public function characters( SerializerNode $parent, $text, $start, $length ) {
		$text = substr( $text, $start, $length );
		return strtr( $text, [
			'<' => '&lt;',
			'>' => '&gt;',
			'&' => '&amp;' ] );
	}

	public function element( SerializerNode $parent, SerializerNode $node, $contents ) {
		$name = $node->name;
		$ret = "<$name";
		foreach ( $node->attrs->getValues() as $attrName => $value ) {
			$ret .= " $attrName=\"" .
				strtr( $value, [
					'"' => '&quot;',
					'&' => '&amp;',
				] ) . "\"";
		}
		if ( $contents === null ) {
			$ret .= " />";
		} elseif ( isset( $contents[0] ) && $contents[0] === "\n"
			&& in_array( $name, [ 'pre', 'textarea', 'listing' ] )
		) {
			$ret .= ">\n$contents</$name>";
		} else {
			$ret .= ">$contents</$name>";
		}
		return $ret;
	}

	public function comment( SerializerNode $parent, $text ) {
		return "<!--$text-->";
	}

	public function doctype( $name, $public, $system ) {
		return '';
	}
}
