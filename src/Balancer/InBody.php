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
			$this->dispatcher->inHead->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
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
			if ( $selfClose ) {
				$balancer->error( self::SELF_CLOSE_ERROR, $sourceStart );
			}
			$balancer->startTag( $name, $attrs, false, $sourceStart, $sourceLength );
			$this->dispatcher->switchMode( Dispatcher::IN_FRAMESET );
			return;
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
			$balancer->closePInButtonScope();
			break;
		case 'h1':
		case 'h2':
		case 'h3':
		case 'h4':
		case 'h5':
		case 'h6':
			$balancer->closePInButtonScope();
			$bottomName = end( $balancer->stack );
			if ( isset( self::$headingNames[$bottomName] ) ) {
				$balancer->error( 'invalid nested heading', $sourceStart );
				$balancer->endTag( $bottomName, $sourceStart, 0 );
			}
			break;
		case 'pre':
		case 'listing':
			$balancer->closePInButtonScope();
			$balancer->framesetOK = false;
			break;
		case 'form':
			if ( $balancer->isFormIgnored() ) {
				$balancer->error( 'invalid nested form', $sourceStart );
				return;
			}
			$balancer->closePInButtonScope();
			$balancer->insertForm( $attrs, $sourceStart, $sourceLength );
			return;
		case 'li':
			$balancer->framesetOK = false;
			$stack =& $balancer->stack;
			$node = end( $stack );
			do {
				if ( $node === 'li' ) {
					$balancer->generateImpliedEndTags( [ 'li' ] );
					if ( end( $stack ) !== 'li' ) {
						$balancer->error( 'current node is not 
		}
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
	}
}
