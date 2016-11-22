<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class InSelectInTable extends InsertionMode {
	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->dispatcher->inSelect->characters(
			$text, $start, $length, $sourceStart, $sourceLength );
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$stack = $builder->stack;
		$dispatcher = $this->dispatcher;

		switch ( $name ) {
		case 'caption':
		case 'table':
		case 'tbody':
		case 'tfoot':
		case 'thead':
		case 'tr':
		case 'td':
		case 'th':
			if ( !$stack->isInTableScope( $name ) ) {
				$builder->error( "unexpected <$name> in select in table, ignoring", $sourceStart );
				return;
			}
			$builder->error( "unexpected <$name> in select in table, closing select",
				$sourceStart );
			$builder->popAllUpToName( 'select', $sourceStart, 0 );
			$dispatcher->reset()
				->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
			break;

		default:
			$dispatcher->inSelect->startTag(
				$name, $attrs, $selfClose, $sourceStart, $sourceLength );
		}
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$stack = $builder->stack;
		$dispatcher = $this->dispatcher;

		switch ( $name ) {
		case 'caption':
		case 'table':
		case 'tbody':
		case 'tfoot':
		case 'thead':
		case 'tr':
		case 'td':
		case 'th':
			if ( !$stack->isInTableScope( $name ) ) {
				$builder->error( "unexpected </$name> in select in table, ignoring",
					$sourceStart );
				return;
			}
			$builder->error( "unexpectd </$name> in select in table, closing select",
				$sourceStart );
			$builder->popAllUpToName( 'select' );
			$dispatcher->reset()
				->endTag( $name, $sourceStart, $sourceLength );
			break;

		default:
			$dispatcher->inSelect->endTag( $name, $sourceStart, $sourceLength );
		}
	}

	public function endDocument( $pos ) {
		$dispatcher->inSelect->endDocument( $pos );
	}
}
