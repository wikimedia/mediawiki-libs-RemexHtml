<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Attributes;
use Wikimedia\RemexHtml\PlainAttributes;

class InBody extends InsertionMode {
	static private $headingNames = ['h1' => true, 'h2' => true, 'h3' => true, 'h4' => true,
		'h5' => true, 'h6' => true];

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		if ( !$this->builder->ignoreNulls ) {
			$this->stripNulls( $text, $start, $length, $sourceStart, $sourceLength );
		} else {
			if ( strcspn( $text, "\t\n\f\r ", $start, $length ) !== $length ) {
				$this->builder->framesetOK = false;
			}
			$this->builder->characters( $text, $start, $length, $sourceStart, $sourceLength );
		}
	}

	function charactersNonNull( $text, $start, $length, $sourceStart, $sourceLength ) {
		if ( strcspn( $text, "\t\n\f\r ", $start, $length ) !== $length ) {
			$this->builder->framesetOK = false;
		}
		$this->builder->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$ack = false;
		$mode = null;
		$tokenizerState = null;
		$isNewAFE = false;
		$builder = $this->builder;
		$stack = $builder->stack;

		switch ( $name ) {
		case 'html':
			$builder->error( 'unexpected html tag', $sourceStart );
			if ( $builder->stackHas( 'template' ) ) {
				// Ignore the token
				return;
			}
			if ( $attrs->count() ) {
				$builder->addHtmlAttrs( $attrs );
			}
			return;
		case 'base':
		case 'basefont':
		case 'bgsound':
		case 'link':
		case 'meta':
		case 'noframes':
		case 'script':
		case 'style':
		case 'template':
		case 'title':
			$this->dispatcher->inHead->startTag(
				$name, $attrs, $selfClose, $sourceStart, $sourceLength );
			return;
		case 'body':
			$builder->error( 'unexpected body tag', $sourceStart );
			if ( $attrs->count() && $this->builder->hasBody ) {
				$builder->addBodyAttrs( $attrs );
			}
			return;
		case 'frameset':
			$builder->error( 'unexpected frameset tag', $sourceStart );
			if ( !$builder->framesetOK || !$builder->hasBody ) {
				return;
			}
			$builder->removeBody();
			$mode = Dispatcher::IN_FRAMESET;
			break;
		case 'address':
		case 'article':
		case 'aside':
		case 'blockquote':
		case 'center':
		case 'details':
		case 'dialog':
		case 'dir':
		case 'div':
		case 'dl':
		case 'fieldset':
		case 'figcaption':
		case 'figure':
		case 'footer':
		case 'header':
		case 'hgroup':
		case 'main':
		case 'nav':
		case 'ol':
		case 'p':
		case 'section':
		case 'summary':
		case 'ul':
			$builder->closePInButtonScope( $sourceStart );
			break;
		case 'h1':
		case 'h2':
		case 'h3':
		case 'h4':
		case 'h5':
		case 'h6':
			$builder->closePInButtonScope( $sourceStart );
			if ( $stack->current->namespace === HTMLData::NS_HTML
				&& isset( self::$headingNames[$stack->current->name] )
			) {
				$builder->error( 'invalid nested heading', $sourceStart );
				$builder->endTag( $bottomName, $sourceStart, 0 );
			}
			break;
		case 'pre':
		case 'listing':
			$builder->closePInButtonScope( $sourceStart );
			$builder->framesetOK = false;
			break;
		case 'form':
			if ( $builder->isFormIgnored() ) {
				$builder->error( 'invalid nested form', $sourceStart );
				return;
			}
			$builder->closePInButtonScope( $sourceStart );
			$builder->insertForm( $attrs, $sourceStart, $sourceLength );
			return;
		case 'li':
			$builder->framesetOK = false;
			$stack =& $builder->tagNameStack;
			$node = end( $stack );
			while ( true ) {
				if ( $node === 'li' ) {
					$builder->generateImpliedEndTags( 'li' );
					$this->popAllDownTo( 'li', $stack );
					break;
				}
				if ( isset( HTMLData::$special[$node] )
					&& $node !== 'address' && $node !== 'div' && $node !== 'p'
				) {
					break;
				}
				$node = prev( $stack );
			}
			$builder->closePInButtonScope( $sourceStart );
			unset( $stack );
			break;
		case 'dd':
		case 'dt':
			$builder->framesetOK = false;
			$stack =& $builder->tagNameStack;
			$node = end( $stack );
			while ( true ) {
				if ( $node === 'dd' || $node === 'dt' ) {
					$builder->generateImpliedEndTags( $node );
					$this->popAllDownTo( $node, $stack );
					break;
				}
				if ( isset( HTMLData::$special[$node] )
					&& $node !== 'address' && $node !== 'div' && $node !== 'p'
				) {
					break;
				}
				$node = prev( $stack );
			}
			$builder->closePInButtonScope( $sourceStart );
			unset( $stack );
			break;
		case 'plaintext':
			$builder->closePInButtonScope( $sourceStart );
			$tokenizerState = Tokenizer::STATE_PLAINTEXT;
			break;
		case 'button':
			if ( $builder->isInScope( 'button' ) ) {
				$builder->error( 'invalid nested button tag', $sourceStart );
				$builder->generateImpliedEndTags();
				$this->popAllDownTo( 'button', $builder->stack );
			}
			$builder->reconstructAFE( $sourceStart );
			$builder->framesetOK = false;
			break;
		case 'a':
			if ( $builder->findAFEAfterMarker( 'a' ) !== false ) {
				$builder->error( 'invalid nested a tag', $sourceStart );
				$this->adoptionAgency( 'a', $sourceStart, 0 );
				$builder->removeAFEAfterMarker( 'a' );
			}
			$builder->reconstructAFE( $sourceStart );
			$isNewAFE = true;
			break;
		case 'b':
		case 'big':
		case 'code':
		case 'em':
		case 'font':
		case 'i':
		case 's':
		case 'small':
		case 'strike':
		case 'strong':
		case 'tt':
		case 'u':
			$builder->reconstructAFE( $sourceStart );
			$isNewAFE = true;
			break;
		case 'nobr':
			$builder->reconstructAFE( $sourceStart );
			if ( $builder->isInElementScope( 'nobr' ) ) {
				$builder->error( 'invalid nested nobr tag', $sourceStart );
				$this->adoptionAgency( 'nobr', $sourceStart, 0 );
				$builder->reconstructAFE( $sourceStart );
			}
			$isNewAFE = true;
			break;
		case 'applet':
		case 'marquee':
		case 'object':
			$builder->reconstructAFE( $sourceStart );
			$builder->addAFEMarker();
			$builder->framesetOK = false;
			break;
		case 'table':
			if ( $builder->quirks !== TreeBuilder::QUIRKS ) {
				$builder->closePInButtonScope( $sourceStart );
			}
			$builder->framesetOK = false;
			$mode = Dispatcher::IN_TABLE;
			break;
		case 'area':
		case 'br':
		case 'embed':
		case 'img':
		case 'keygen':
		case 'wbr':
			$builder->reconstructAFE( $sourceStart );
			$ack = true;
			$builder->framesetOK = false;
			break;
		case 'input':
			$builder->reconstructAFE( $sourceStart );
			$ack = true;
			if ( !isset( $attribs['type'] ) || strcasecmp( $attribs['type'], 'hidden' ) !== 0 ) {
				$builder->framesetOK = false;
			}
			break;
		case 'param':
		case 'source':
		case 'track':
			$ack = true;
			break;
		case 'hr':
			$builder->closePInButtonScope( $sourceStart );
			$ack = true;
			$builder->framesetOK = false;
			break;
		case 'image':
			$builder->error( 'invalid "image" tag, assuming "img"', $sourceStart );
			$this->startTag( 'img', $attrs, $selfClose, $sourceStart, $sourceLength );
			return;
		case 'textarea':
			$tokenizerState = Tokenizer::STATE_RCDATA;
			$textMode = Dispatcher::TEXT;
			$builder->framesetOK = false;
			break;
		case 'xmp':
			$builder->closePInButtonScope( $sourceStart );
			$builder->reconstructAFE( $sourceStart );
			$builder->framesetOK = false;
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'iframe':
			$builder->framesetOK = false;
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'noscript':
			if ( !$builder->scriptingFlag ) {
				$builder->reconstructAFE( $sourceStart );
				break;
			}
			// fall through
		case 'noembed':
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'select':
			$builder->reconstructAFE( $sourceStart );
			$builder->framesetOK = false;
			if ( $dispatcher->isInTableMode() ) {
				$mode = Dispatcher::IN_SELECT_IN_TABLE;
			} else {
				$mode = Dispatcher::IN_SELECT;
			}
			break;
		case 'optgroup':
		case 'option':
			if ( end( $builder->tagNameStack ) === 'option' ) {
				$builder->endTag( 'option', $sourceStart, 0 );
			}
			$builder->reconstructAFE( $sourceStart );
			break;
		case 'rb':
		case 'rp':
		case 'rtc':
			if ( $builder->isInScope( 'ruby' ) ) {
				$builder->generateImpliedEndTags();
				if ( end( $builder->tagNameStack ) !== 'ruby' ) {
					$builder->error( "<$name> is not a child of <ruby>", $sourceStart );
				}
			}
			break;
		case 'rt':
			if ( $builder->isInScope( 'ruby' ) ) {
				$builder->generateImpliedEndTags( 'rtc' );
				if ( !in_array( end( $builder->tagNameStack ), [ 'ruby', 'rtc' ] ) ) {
					$builder->error( "<$name> is not a child of <ruby> or <rtc>", $sourceStart );
				}
			}
			break;
		case 'caption':
		case 'col':
		case 'colgroup':
		case 'frame':
		case 'head':
		case 'tbody':
		case 'td':
		case 'tfoot':
		case 'th':
		case 'thead':
		case 'tr':
			$builder->error( "$name is invalid in body mode" );
			return;
		case 'math':
		case 'svg':
		case 'isindex':
			// TODO
			$builder->error( "$name is unimplemented" );
			// fall through
		default:
			$builder->reconstructAFE( $sourceStart );
		}

		// Generic element insertion, for all cases that didn't return above
		if ( !$ack && $selfClose ) {
			$builder->error( self::SELF_CLOSE_ERROR, $sourceStart );
		}
		if ( $isNewAFE ) {
			$builder->startFormattingElement( $name, $attrs, $ack, $sourceStart, $sourceLength );
		} else {
			$builder->startTag( $name, $attrs, $ack, $sourceStart, $sourceLength );
		}
		if ( $tokenizerState !== null ) {
			$builder->tokenizer->switchState( $tokenizerState, $name );
		}
		if ( $mode !== null ) {
			$this->dispatcher->switchMode( $mode );
		} elseif ( $textMode !== null ) {
			$this->dispatcher->switchMode( $textMode, true );
		}
	}

	private function popAllDownTo( $terminator, &$stack ) {
		$builder = $this->builder;
		$builder->generateImpliedEndTags( $terminator );
		while ( false !== ( $node = end( $stack ) ) ) {
			$builder->endTag( $node, $sourceStart, 0 );
			if ( $node === $terminator ) {
				break;
			}
		}
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		case 'address':
		case 'article':
		case 'aside':
		case 'blockquote':
		case 'button':
		case 'center':
		case 'details':
		case 'dialog':
		case 'dir':
		case 'div':
		case 'dl':
		case 'fieldset':
		case 'figcaption':
		case 'figure':
		case 'footer':
		case 'header':
		case 'hgroup':
		case 'listing':
		case 'main':
		case 'nav':
		case 'ol':
		case 'pre':
		case 'section':
		case 'summary':
		case 'ul':	



		case 'a':
		case 'b':
		case 'big':
		case 'code':
		case 'em':
		case 'font':
		case 'i':
		case 'nobr':
		case 's':
		case 'small':
		case 'strike':
		case 'strong':
		case 'tt':
		case 'u':

	}
}
