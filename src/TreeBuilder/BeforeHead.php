<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\PlainAttributes;

class BeforeHead extends InsertionMode {
	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$wsLength = strspn( $text, "\t\n\f\r ", $start, $length );
		$length -= $wsLength;
		if ( !$length ) {
			return;
		}
		$start += $wsLength;
		$this->builder->startTag( 'head', new PlainAttributes, false, $sourceStart, 0 );
		$this->dispatcher->switchMode( Dispatcher::IN_HEAD )
			->characters( $text, $start, $length, $sourceStart, $sourceLength );
		// TODO set head element pointer
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		if ( $name === 'html' ) {
			$this->dispatcher->inBody->startTag( $name, $attrs, $selfClose,
				$sourceStart, $sourceLength );
		} elseif ( $name === 'head' ) {
			$this->builder->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			// TODO set head element pointer
		} else {
			$this->builder->startTag( 'head', new PlainAttributes, false, $sourceStart, 0 );
			// TODO set head element pointer
			$this->dispatcher->switchMode( Dispatcher::IN_HEAD )
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
		}
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		$allowed = [ "head" => true, "body" => true, "html" => true, "br" => true ];
		if ( !isset( $allowed[$name] ) ) {
			$this->builder->error( 'end tag not allowed before head', $sourceStart );
			return;
		}
		$this->builder->startTag( 'head', new PlainAttributes, false, $sourceStart, 0 );
		// TODO set head element pointer
		$this->dispatcher->switchMode( Dispatcher::IN_HEAD )
			->endTag( $name, $sourceStart, $sourceLength );
	}
}
