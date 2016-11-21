<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Attributes;

class InCaption extends InsertionMode {
	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->dispatcher->inBody->characters( $text, $start, $length,
			$sourceStart, $sourceLength );
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$builder = $this->builder;
		$stack = $builder->stack;
		switch ( $name ) {
			case 'caption':
			case 'col':
			case 'colgroup':
			case 'tbody':
			case 'td':
			case 'tfoot':
			case 'th':
			case 'thead':
			case 'tr':
				$builder->error( "start tag <$name> not allowed in caption", $sourceStart );
				if ( !$stack->isInScope( 'caption' ) ) {
					// Ignore
					return;
				}
				$builder->popAllUpToName( 'caption', $sourceStart, 0 );
				$builder->afe->clearToMarker();
				$this->dispatcher->switchMode( Dispatcher::IN_TABLE )
					->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
				break;
			default:
				$this->dispatcher->inBody->startTag( $name, $attrs, $selfClose,
					$sourceStart, $sourceLength );
		}
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		switch ( $name ) {
			case 'body':
			case 'col':
			case 'colgroup':
			case 'html':
			case 'tbody':
			case 'td':
			case 'tfoot':
			case 'th':
			case 'thead':
			case 'tr':
				$this->builder->error( "end tag </$name> ignored in caption mode", $sourceStart );
				break;
			default:
				$this->dispatcher->inBody->endTag( $name, $sourceStart, $sourceLength );
		}
	}

	public function endDocument( $pos ) {
		$this->dispatcher->inBody->endDocument( $pos );
	}
}
