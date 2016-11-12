<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Attributes;
use Wikimedia\RemexHtml\PlainAttributes;

class InTable extends InsertionMode {
	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$allowed = [
			'table' => true,
			'tbody' => true,
			'tfoot' => true,
			'thead' => true,
			'tr' => true ];
		if ( isset( $allowed[$this->builder->stack->current->htmlName] ) ) {
			$this->builder->pendingTableCharacters = [];
			$this->dispatcher->switchMode( Dispatcher::IN_TABLE_TEXT, true )
				->characters( $text, $start, $length, $sourceStart, $sourceLength );
		} else {
			$this->builder->error( 'unexpected text in table', $sourceStart );
			$this->builder->fosterParenting = true;
			$this->dispatcher->inBody->characters(
				$text, $start, $length, $sourceStart, $sourceLength );
			$this->builder->fosterParenting = false;
		}
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$dispatcher = $this->dispatcher;
		$stack = $builder->stack;

		switch ( $name ) {
		case 'caption':
			$this->clearStackBack( $sourceStart );
			$builder->afe->insertMarker();
			$dispatcher->switchMode( Dispatcher::IN_CAPTION );
			$builder->insertElement( $name, $attrs, $selfClose, false,
				$sourceStart, $sourceLength );
			break;

		case 'colgroup':
			$this->clearStackBack( $sourceStart );
			$dispatcher->switchMode( Dispatcher::IN_COLUMN_GROUP );
			$builder->insertElement( $name, $attrs, $selfClose, false,
				$sourceStart, $sourceLength );
			break;

		case 'col':
			$this->clearStackBack( $sourceStart );
			$builder->insertElement( 'colgroup', new PlainAttributes, false, false,
				$sourceStart, 0 );
			$dispatcher->switchMode( Dispatcher::IN_COLUMN_GROUP )
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			break;

		case 'tbody':
		case 'tfoot':
		case 'thead':
			$this->clearStackBack( $sourceStart );
			$builder->insertElement( $name, $attrs, $selfClose, false,
				$sourceStart, $sourceLength );
			$dispatcher->switchMode( Dispatcher::IN_TABLE_BODY );
			break;

		case 'td':
		case 'th':
		case 'tr':
			$this->clearStackBack( $sourceStart );
			$builder->insertElement( 'tbody', new PlainAttributes, false, false,
				$sourceStart, $sourceLength );
			$dispatcher->switchMode( Dispatcher::IN_TABLE_BODY )
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			break;

		case 'table':
			$this->error( 'unexpected <table> in table' );
			if ( !$stack->isInTableScope( 'table' ) ) {
				// Ignore
				break;
			}
			$builder->popAllUpTo( 'table', $sourceStart, 0 );
			$dispatcher->reset()
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			break;

		case 'style':
		case 'script':
		case 'template':
			$dispatcher->inHead->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			break;

		case 'form':
			$builder->error( 'invalid form in table', $sourcePos );
			if ( $stack->hasTemplate() || $builder->formElement !== null ) {
				// Ignore
				break;
			}
			if ( $selfClose ) {
				$builder->error( TreeBuilder::SELF_CLOSE_ERROR, $sourceStart );
			}
			$elt = $builder->insertElement( 'form', $attrs, true, true,
				$sourceStart, $sourceLength );
			$builder->formElement = $elt;
			break;

		case 'input':
			if ( isset( $attrs['type'] ) && strncmp( $attrs['type'], 'hidden' ) === 0 ) {
				$builder->error( 'begrudgingly accepting a hidden input in table mode',
					$sourcePos );
				$builder->insertElement( $name, $attrs, true, true );
				break;
			}
			// Fall through

		default:
			$builder->error( 'invalid start tag in table', $sourceStart );
			$builder->fosterParenting = true;
			$dispatcher->inBody->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			$builder->fosterParenting = false;
			break;
		}
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$stack = $builder->stack;
		$dispatcher = $this->dispatcher;

		switch ( $name ) {
		case 'table':
			if ( !$stack->isInScope( 'table' ) ) {
				$builder->error( '</table> found but no table element in scope' );
				// Ignore
				break;
			}
			$builder->popAllUpTo( 'table', $sourceStart, $sourceLength );
			$dispatcher->reset();
			break;

		case 'body':
		case 'caption':
		case 'col':
		case 'colgroup':
		case 'html':
		case 'tbody':
		case 'td':
		case 'tfoot':
		case 'th':
		case 'thead':
		case 'tr':
			$builder->error( 'ignoring invalid end tag inside table' );
			break;

		case 'template':
			$dispatcher->inHead->startTag( $name, $attrs, $selfClose,
				$sourceStart, $sourceLength );
			break;
		}
	}

	public function endDocument( $pos ) {
		$this->dispatcher->inBody->endDocument( $pos );
	}
}
