<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;

class InHead extends InsertionMode {
	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$wsLength = strspn( $text, "\t\n\f\r ", $start, $length );
		if ( $wsLength ) {
			$this->builder->characters( $text, $start, $wsLength, $sourceStart,
				$sourceLength );
		}
		$length -= $wsLength;
		if ( !$length ) {
			return;
		}
		$start += $wsLength;

		$elt = $this->builder->pop( $sourceStart, 0 );
		if ( $elt->htmlName !== 'head' ) {
			throw new \Exception( 'In head mode but current element is not <head>' );
		}
		$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
			->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$void = false;
		$tokenizerState = null;
		$textMode = null;
		$mode = null;
		$builder = $this->builder;
		$dispatcher = $this->dispatcher;

		switch ( $name ) {
		case 'html':
			$this->dispatcher->inBody->startTag( $name, $attrs, $selfClose,
				$sourceStart, $sourceLength );
			return;
		case 'base':
		case 'basefont':
		case 'bgsound':
		case 'link':
			$void = true;
			$dispatcher->ack = true;
			break;
		case 'meta':
			$void = true;
			$dispatcher->ack = true;
			// charset handling omitted
			break;
		case 'title':
			$tokenizerState = Tokenizer::STATE_RCDATA;
			$textMode = Dispatcher::TEXT;
			break;
		case 'noscript':
			if ( !$this->builder->scriptingFlag ) {
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
			$this->builder->afe->insertMarker();
			$this->builder->framesetOK = false;
			$mode = Dispatcher::IN_TEMPLATE;
			$this->dispatcher->templateModeStack->push( Dispatcher::IN_TEMPLATE );
			break;
		case 'head':
			$this->builder->error( 'unexpected head tag', $sourceStart );
			return;
		default:
			$elt = $this->builder->pop( $sourceStart, 0 );
			if ( $elt->htmlName !== 'head' ) {
				throw new \Exception( "In head mode but current element is not <head>" );
			}
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			return;
		}

		// Generic element insertion, for all cases that didn't return above
		$this->builder->insertElement( $name, $attrs, $void,
			$sourceStart, $sourceLength );
		if ( $tokenizerState !== null ) {
			$this->builder->tokenizer->switchState( $tokenizerState, $name );
		}
		if ( $textMode !== null ) {
			$this->dispatcher->switchMode( $textMode, true );
		} elseif ( $mode !== null ) {
			$this->dispatcher->switchMode( $mode );
		}
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$stack = $builder->stack;

		switch ( $name ) {
		case 'head':
			$builder->pop( $sourceStart, $sourceLength );
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD );
			break;
		case 'body':
		case 'html':
		case 'br':
			$builder->pop( $sourceStart, 0 );
			$this->dispatcher->switchMode( Dispatcher::AFTER_HEAD )
				->endTag( $name, $sourceStart, $sourceLength );
			break;
		case 'template':
			if ( !$stack->hasTemplate() ) {
				$this->error( 'unexpected </template>', $sourceStart );
				return;
			}
			$builder->generateImpliedEndTags( $sourceStart );
			if ( $stack->current->htmlName !== 'template' ) {
				$this->error( 'encountered </template> when other tags are still open' );
			}
			$builder->popAllUpTo( 'template', $sourceStart, $sourceLength );
			$builder->afe->clearToMarker();
			$this->dispatcher->templateModeStack->pop();
			$this->dispatcher->reset();
			break;
		default:
			$builder->error( 'ignoring unexpected end tag', $sourceStart );
		}
	}
}
