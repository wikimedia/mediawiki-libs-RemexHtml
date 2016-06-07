<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;

class InHead extends InsertionMode {
	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$wsLength = strspn( $text, "\t\n\f\r ", $start, $length );
		if ( $wsLength ) {
			$this->balancer->characters( $text, $start, $wsLength, $sourceStart,
				$sourceLength );
		}
		$length -= $wsLength;
		if ( !$length ) {
			return;
		}
		$start += $wsLength;

		$this->balancer->endTag( 'head', $sourceStart, 0 );
		$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
			->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$ack = false;
		$tokenizerState = null;
		$textMode = null;
		$mode = null;

		switch ( $name ) {
		case 'html':
			$this->dispatcher->inBody->startTag( $name, $attrs, $selfClose,
				$sourceStart, $sourceLength );
			return;
		case 'base':
		case 'basefont':
		case 'bgsound':
		case 'link':
			$ack = true;
			break;
		case 'meta':
			$ack = true;
			// charset handling omitted
			break;
		case 'title':
			$tokenizerState = Tokenizer::STATE_RCDATA;
			$textMode = Dispatcher::TEXT;
			break;
		case 'noscript':
			if ( !$this->balancer->scriptingFlag ) {
				$mode = Dispatcher::HEAD_NOSCRIPT;
				break;
			}
			// Fall through
		case 'noframes':
		case 'style':
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'script':
			$tokenizerState = Tokenizer::STATE_SCRIPT_DATA;
			$textMode = Dispatcher::TEXT;
			break;
		case 'template':
			$this->balancer->insertAfeMarker();
			$this->balancer->framesetOK = false;
			$mode = Dispatcher::IN_TEMPLATE;
			$this->balancer->pushTemplateMode( Balancer::IN_TEMPLATE );
			break;
		case 'head':
			$this->balancer->error( 'unexpected head tag', $sourceStart );
			return;
		default:
			$this->balancer->endTag( 'head', $sourceStart, 0 );
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			return;
		}

		// Generic element insertion, for all cases that didn't return above
		if ( !$ack && $selfClose ) {
			$this->balancer->error( InsertionMode::SELF_CLOSE_ERROR, $sourceStart );
		}
		$this->balancer->startTag( $name, $attrs, $ack, $sourceStart, $sourceLength );
		if ( $tokenizerState !== null ) {
			$this->balancer->tokenizer->switchState( $tokenizerState, $name );
		}
		if ( $textMode !== null ) {
			$this->dispatcher->switchMode( $textMode, Dispatcher::IN_HEAD );
		} elseif ( $mode !== null ) {
			$this->dispatcher->switchMode( $mode );
		}
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		switch ( $name ) {
		case 'head':
			$this->balancer->endTag( $name, $sourceStart, $sourceLength );
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD );
			break;
		case 'body':
		case 'html':
		case 'br':
			$this->balancer->endTag( 'head', $sourceStart, 0 );
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
				->endTag( $name, $sourceStart, $sourceLength );
			break;
		case 'template':
			$this->balancer->endTemplateTag( $sourceStart, $sourceLength );
			break;
		default:
			$this->balancer->error( 'ignoring unexpected end tag', $sourceStart );
		}
	}
}
