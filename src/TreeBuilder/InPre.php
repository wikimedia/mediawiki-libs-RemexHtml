<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

/**
 * This is not a tree builder state in the spec. I added it to handle the
 * "next token" references in pre/listing
 */
class InPre extends InsertionMode {
	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		if ( $length > 0 && $text[$start] === "\n" ) {
			$start++;
			$length--;
			$sourceStart++;
			$sourceLength--;
		}
		$mode = $this->dispatcher->restoreMode();
		if ( $length ) {
			$mode->characters( $text, $start, $length, $sourceStart, $sourceLength );
		}
	}

	public function endDocument( $pos ) {
		$this->dispatcher->restoreMode()
			->endDocument( $pos );
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$this->dispatcher->restoreMode()
			->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$this->dispatcher->restoreMode()
			->endTag( $name, $sourceStart, $sourceLength );
	}
}
