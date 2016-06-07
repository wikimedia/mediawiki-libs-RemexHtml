<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Attributes;
use Wikimedia\RemexHtml\Tokenizer\TokenHandler;

abstract class InsertionMode implements TokenHandler {
	const SELF_CLOSE_ERROR = 'unacknowledged self closing tag';

	function __construct( Balancer $balancer, Dispatcher $dispatcher ) {
		$this->balancer = $balancer;
		$this->dispatcher = $dispatcher;
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->balancer->error( "unexpected doctype" );		
	}

	function comment( $text, $sourceStart, $sourceLength ) {
		$this->balancer->comment( $text, $sourceStart, $sourceLength );
	}

	function error( $text, $pos ) {
		$this->balancer->error( $text, $pos );
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

