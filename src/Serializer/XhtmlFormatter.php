<?php

namespace RemexHtml\Serializer;

class XhtmlFormatter implements Formatter {
	private $ignoreEntities;

	function __construct( $options = [] ) {
		$options += [
			'ignoreEntities' => false,
		];
		$this->ignoreEntities = $options['ignoreEntities'];
	}

	function startDocument( $fragmentNamespace, $fragmentName ) {
		return "<!DOCTYPE html>\n";
	}

	function characters( $text, $start, $length ) {
		$text = substr( $text, $start, $length );
		if ( $this->ignoreEntities ) {
			return $text;
		} else {
			return strtr( $text, [
				'<' => '&lt;',
				'>' => '&gt;',
				'&' => '&amp;' ] );
		}
	}

	function element( $namespace, $name, Attributes $attrs, $contents ) {
		$ret = "<$name";
		if ( $this->ignoreEntities ) {
			foreach ( $attrs->getValues() as $name => $value ) {
				$ret .= " $name=\"$value\"";
			}
		} else {
			foreach ( $attrs->getValues() as $name => $value ) {
				$ret .= " $name=\"" .
					strtr( $value, [
						'"' => '&quot;',
						'&' => '&amp;',
					] );
			}
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
