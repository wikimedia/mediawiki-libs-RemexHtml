<?php

namespace RemexHtml\Serializer;
use RemexHtml\Tokenizer\Attributes;

class XhtmlFormatter implements Formatter {
	function startDocument( $fragmentNamespace, $fragmentName ) {
		return "<!DOCTYPE html>\n";
	}

	function characters( $text, $start, $length ) {
		$text = substr( $text, $start, $length );
		return strtr( $text, [
			'<' => '&lt;',
			'>' => '&gt;',
			'&' => '&amp;' ] );
	}

	function element( $namespace, $name, Attributes $attrs, $contents ) {
		$ret = "<$name";
		foreach ( $attrs->getValues() as $name => $value ) {
			$ret .= " $name=\"" .
				strtr( $value, [
					'"' => '&quot;',
					'&' => '&amp;',
				] );
		}
		if ( $contents === null ) {
			$ret .= "/>";
		} elseif ( isset( $contents[0] ) && $contents[0] === "\n"
			&& in_array( $name, [ 'pre', 'textarea', 'listing' ] )
		) {
			$ret .= ">\n$contents</$name>";
		} else {
			$ret .= ">$contents</$name>";
		}
		return $ret;
	}

	function comment( $text ) {
		return "<!--$text-->";
	}
}
