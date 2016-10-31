<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Attributes;
use Wikimedia\RemexHtml\Tokenizer\TokenHandler;

abstract class InsertionMode implements TokenHandler {
	const SELF_CLOSE_ERROR = 'unacknowledged self closing tag';

	function __construct( TreeBuilder $builder, Dispatcher $dispatcher ) {
		$this->builder = $builder;
		$this->dispatcher = $dispatcher;
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->builder->error( "unexpected doctype" );		
	}

	function comment( $text, $sourceStart, $sourceLength ) {
		$this->builder->comment( $text, $sourceStart, $sourceLength );
	}

	function error( $text, $pos ) {
		$this->builder->error( $text, $pos );
	}

	function stripNulls( $text, $start, $length, $sourceStart, $sourceLength ) {
		$originalLength = $length;
		$errorOffset = $sourceStart - $start;
		while ( $length > 0 ) {
			$validLength = strcspn( $text, "\0", $start, $length );
			$this->charactersNonNull( $text, $start, $validLength, $sourceStart, $sourceLength );
			$start += $validLength;
			$length -= $validLength;
			if ( $length <= 0 ) {
				break;
			}
			$this->error( 'unexpected U+0000', $start + $errorOffset );
			$start++;
			$length--;
		}
	}
}

