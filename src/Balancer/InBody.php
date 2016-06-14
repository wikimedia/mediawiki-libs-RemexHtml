<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Attributes;
use Wikimedia\RemexHtml\PlainAttributes;

class InBody extends InsertionMode {
	static private $headingNames = ['h1' => true, 'h2' => true, 'h3' => true, 'h4' => true,
		'h5' => true, 'h6' => true];

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		if ( !$this->balancer->ignoreNulls ) {
			$this->stripNulls( $text, $start, $length, $sourceStart, $sourceLength );
		} else {
			if ( strcspn( $text, "\t\n\f\r ", $start, $length ) !== $length ) {
				$this->balancer->framesetOK = false;
			}
			$this->balancer->characters( $text, $start, $length, $sourceStart, $sourceLength );
		}
	}

	function charactersNonNull( $text, $start, $length, $sourceStart, $sourceLength ) {
		if ( strcspn( $text, "\t\n\f\r ", $start, $length ) !== $length ) {
			$this->balancer->framesetOK = false;
		}
		$this->balancer->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$ack = false;
		$mode = null;
		$tokenizerState = null;
		$isNewAFE = false;
		$balancer = $this->balancer;

		switch ( $name ) {
		case 'html':
			$balancer->error( 'unexpected html tag', $sourceStart );
			if ( $balancer->stackHas( 'template' ) ) {
				// Ignore the token
				return;
			}
			if ( $attrs->count() ) {
				$balancer->addHtmlAttrs( $attrs );
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
			$balancer->error( 'unexpected body tag', $sourceStart );
			if ( $attrs->count() && $this->balancer->hasBody ) {
				$balancer->addBodyAttrs( $attrs );
			}
			return;
		case 'frameset':
			$balancer->error( 'unexpected frameset tag', $sourceStart );
			if ( !$balancer->framesetOK || !$balancer->hasBody ) {
				return;
			}
			$balancer->removeBody();
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
			$balancer->closePInButtonScope( $sourceStart );
			break;
		case 'h1':
		case 'h2':
		case 'h3':
		case 'h4':
		case 'h5':
		case 'h6':
			$balancer->closePInButtonScope( $sourceStart );
			$bottomName = end( $balancer->tagNameStack );
			if ( isset( self::$headingNames[$bottomName] ) ) {
				$balancer->error( 'invalid nested heading', $sourceStart );
				$balancer->endTag( $bottomName, $sourceStart, 0 );
			}
			break;
		case 'pre':
		case 'listing':
			$balancer->closePInButtonScope( $sourceStart );
			$balancer->framesetOK = false;
			break;
		case 'form':
			if ( $balancer->isFormIgnored() ) {
				$balancer->error( 'invalid nested form', $sourceStart );
				return;
			}
			$balancer->closePInButtonScope( $sourceStart );
			$balancer->insertForm( $attrs, $sourceStart, $sourceLength );
			return;
		case 'li':
			$balancer->framesetOK = false;
			$stack =& $balancer->tagNameStack;
			$node = end( $stack );
			while ( true ) {
				if ( $node === 'li' ) {
					$balancer->generateImpliedEndTags( 'li' );
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
			$balancer->closePInButtonScope( $sourceStart );
			unset( $stack );
			break;
		case 'dd':
		case 'dt':
			$balancer->framesetOK = false;
			$stack =& $balancer->tagNameStack;
			$node = end( $stack );
			while ( true ) {
				if ( $node === 'dd' || $node === 'dt' ) {
					$balancer->generateImpliedEndTags( $node );
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
			$balancer->closePInButtonScope( $sourceStart );
			unset( $stack );
			break;
		case 'plaintext':
			$balancer->closePInButtonScope( $sourceStart );
			$tokenizerState = Tokenizer::STATE_PLAINTEXT;
			break;
		case 'button':
			if ( $balancer->isInScope( 'button' ) ) {
				$balancer->error( 'invalid nested button tag', $sourceStart );
				$balancer->generateImpliedEndTags();
				$this->popAllDownTo( 'button', $balancer->stack );
			}
			$balancer->reconstructAFE( $sourceStart );
			$balancer->framesetOK = false;
			break;
		case 'a':
			if ( $balancer->findAFEAfterMarker( 'a' ) !== false ) {
				$balancer->error( 'invalid nested a tag', $sourceStart );
				$balancer->adoptionAgency( 'a', $sourceStart, 0 );
				$balancer->removeAFEAfterMarker( 'a' );
			}
			$balancer->reconstructAFE( $sourceStart );
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
			$balancer->reconstructAFE( $sourceStart );
			$isNewAFE = true;
			break;
		case 'nobr':
			$balancer->reconstructAFE( $sourceStart );
			if ( $balancer->isInElementScope( 'nobr' ) ) {
				$balancer->error( 'invalid nested nobr tag', $sourceStart );
				$balancer->adoptionAgency( 'nobr', $sourceStart, 0 );
				$balancer->reconstructAFE( $sourceStart );
			}
			$isNewAFE = true;
			break;
		case 'applet':
		case 'marquee':
		case 'object':
			$balancer->reconstructAFE( $sourceStart );
			$balancer->addAFEMarker();
			$balancer->framesetOK = false;
			break;
		case 'table':
			if ( $balancer->quirks !== Balancer::QUIRKS ) {
				$balancer->closePInButtonScope( $sourceStart );
			}
			$balancer->framesetOK = false;
			$mode = Dispatcher::IN_TABLE;
			break;
		case 'area':
		case 'br':
		case 'embed':
		case 'img':
		case 'keygen':
		case 'wbr':
			$balancer->reconstructAFE( $sourceStart );
			$ack = true;
			$balancer->framesetOK = false;
			break;
		case 'input':
			$balancer->reconstructAFE( $sourceStart );
			$ack = true;
			if ( !isset( $attribs['type'] ) || strcasecmp( $attribs['type'], 'hidden' ) !== 0 ) {
				$balancer->framesetOK = false;
			}
			break;
		case 'param':
		case 'source':
		case 'track':
			$ack = true;
			break;
		case 'hr':
			$balancer->closePInButtonScope( $sourceStart );
			$ack = true;
			$balancer->framesetOK = false;
			break;
		case 'image':
			$balancer->error( 'invalid "image" tag, assuming "img"', $sourceStart );
			$this->startTag( 'img', $attrs, $selfClose, $sourceStart, $sourceLength );
			return;
		case 'textarea':
			$tokenizerState = Tokenizer::STATE_RCDATA;
			$textMode = Dispatcher::TEXT;
			$balancer->framesetOK = false;
			break;
		case 'xmp':
			$balancer->closePInButtonScope( $sourceStart );
			$balancer->reconstructAFE( $sourceStart );
			$balancer->framesetOK = false;
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'iframe':
			$balancer->framesetOK = false;
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'noscript':
			if ( !$balancer->scriptingFlag ) {
				$balancer->reconstructAFE( $sourceStart );
				break;
			}
			// fall through
		case 'noembed':
			$tokenizerState = Tokenizer::STATE_RAWTEXT;
			$textMode = Dispatcher::TEXT;
			break;
		case 'select':
			$balancer->reconstructAFE( $sourceStart );
			$balancer->framesetOK = false;
			if ( $dispatcher->isInTableMode() ) {
				$mode = Dispatcher::IN_SELECT_IN_TABLE;
			} else {
				$mode = Dispatcher::IN_SELECT;
			}
			break;
		case 'optgroup':
		case 'option':
			if ( end( $balancer->tagNameStack ) === 'option' ) {
				$balancer->endTag( 'option', $sourceStart, 0 );
			}
			$balancer->reconstructAFE( $sourceStart );
			break;
		case 'rb':
		case 'rp':
		case 'rtc':
			if ( $balancer->isInScope( 'ruby' ) ) {
				$balancer->generateImpliedEndTags();
				if ( end( $balancer->tagNameStack ) !== 'ruby' ) {
					$balancer->error( "<$name> is not a child of <ruby>", $sourceStart );
				}
			}
			break;
		case 'rt':
			if ( $balancer->isInScope( 'ruby' ) ) {
				$balancer->generateImpliedEndTags( 'rtc' );
				if ( !in_array( end( $balancer->tagNameStack ), [ 'ruby', 'rtc' ] ) ) {
					$balancer->error( "<$name> is not a child of <ruby> or <rtc>", $sourceStart );
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
			$balancer->error( "$name is invalid in body mode" );
			return;
		case 'math':
		case 'svg':
		case 'isindex':
			// TODO
			$balancer->error( "$name is unimplemented" );
			// fall through
		default:
			$balancer->reconstructAFE( $sourceStart );
		}

		// Generic element insertion, for all cases that didn't return above
		if ( !$ack && $selfClose ) {
			$balancer->error( self::SELF_CLOSE_ERROR, $sourceStart );
		}
		if ( $isNewAFE ) {
			$balancer->startFormattingElement( $name, $attrs, $ack, $sourceStart, $sourceLength );
		} else {
			$balancer->startTag( $name, $attrs, $ack, $sourceStart, $sourceLength );
		}
		if ( $tokenizerState !== null ) {
			$balancer->tokenizer->switchState( $tokenizerState, $name );
		}
		if ( $mode !== null ) {
			$this->dispatcher->switchMode( $mode );
		} elseif ( $textMode !== null ) {
			$this->dispatcher->switchMode( $textMode, true );
		}
	}

	private function popAllDownTo( $terminator, &$stack ) {
		$balancer = $this->balancer;
		$balancer->generateImpliedEndTags( $terminator );
		while ( false !== ( $node = end( $stack ) ) ) {
			$balancer->endTag( $node, $sourceStart, 0 );
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
