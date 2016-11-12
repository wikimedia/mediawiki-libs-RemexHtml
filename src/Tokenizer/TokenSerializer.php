<?php

namespace Wikimedia\RemexHtml\Tokenizer;

/**
 * A simple serializer for the token stream, mostly meant for debugging.
 */
class TokenSerializer implements TokenHandler {
	private $output;
	private $errors = [];

	public function getOutput() {
		return $this->output;
	}

	public function getErrors() {
		return $this->errors;
	}

	function startDocument() {
		$this->output = '';
	}

	function endDocument( $pos ) {
	}

	function error( $text, $pos ) {
		$this->errors[] = [ $text, $pos ];
	}

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->output .= htmlspecialchars( substr( $text, $start, $length ) );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$attrs = $attrs->getArrayCopy();
		$this->output .= "<$name";
		foreach ( $attrs as $name => $value ) {
			$this->output .= " $name=\"" . str_replace( '"', '&quot;', $value ) . '"';
		}
		if ( $selfClose ) {
			$this->output .= ' /';
		}
		$this->output .= '>';
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		$this->output .= "</$name>";
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->output .= "<!DOCTYPE $name";
		if ( strlen( $public ) ) {
			$this->output .= " PUBLIC \"$public\"";
			if ( strlen( $system ) ) {
				$this->output .= " \"$system\"";
			}
		} elseif ( strlen( $system ) ) {
			$this->output .= " SYSTEM \"$system\"";
		}
		$this->output .= '>';
		if ( $quirks ) {
			$this->output .= '<!--quirks-->';
		}
	}

	function comment( $text, $sourceStart, $sourceLength ) {
		$this->output .= '<!--' . $text . '-->';
	}
}
