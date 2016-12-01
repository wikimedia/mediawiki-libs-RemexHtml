<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\HTMLData;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\PlainAttributes;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;

class TreeBuilder {
	// Quirks
	const NO_QUIRKS = 0;
	const LIMITED_QUIRKS = 1;
	const QUIRKS = 2;

	// Insertion placement
	const BEFORE = 0;
	const BELOW = 1;
	const ROOT = 2;

	// Configuration
	public $isIframeSrcdoc;
	public $scriptingFlag;
	public $ignoreErrors;
	public $ignoreNulls;

	// Objects
	public $handler;
	public $stack;
	public $afe;
	public $tokenizer;

	// State
	public $isFragment = false;
	public $fragmentContext;
	public $headElement;
	public $formElement;
	public $framesetOK = true;
	public $quirks = self::NO_QUIRKS;
	public $fosterParenting = false;

	private static $fosterTriggers = [
		'table' => true,
		'tbody' => true,
		'tfoot' => true,
		'thead' => true,
		'tr' => true
	];

	private static $impliedEndTags = [
		'dd' => true,
		'dt' => true,
		'li' => true,
		'option' => true,
		'optgroup' => true,
		'p' => true,
		'rb' => true,
		'rt' => true,
		'rtc' => true,
	];

	public function __construct( TreeHandler $handler, $options = [] ) {
		$this->handler = $handler;
		$this->afe = new ActiveFormattingElements;
		$options = $options + [
			'isIframeSrcdoc' => false,
			'scriptingFlag' => true,
			'ignoreErrors' => false,
			'ignoreNulls' => false,
			'scopeCache' => true,
		];

		$this->isIframeSrcdoc = $options['isIframeSrcdoc'];
		$this->scriptingFlag = $options['scriptingFlag'];
		$this->ignoreErrors = $options['ignoreErrors'];
		$this->ignoreNulls = $options['ignoreNulls'];

		if ( $options['scopeCache'] ) {
			$this->stack = new CachingStack;
		} else {
			$this->stack = new SimpleStack;
		}
	}

	/**
	 * Do not call this directly. Use Dispatcher::setFragmentContext().
	 *
	 * @param string $namespace The namespace of the context element
	 * @param string $name The name of the context element
	 */
	public function setFragmentContext( $namespace, $name ) {
		$this->isFragment = true;
		$this->fragmentContext = new Element( HTMLData::NS_HTML, $name,
			new PlainAttributes );
		$this->fragmentContext->isVirtual = true;
		$html = new Element( HTMLData::NS_HTML, 'html', new PlainAttributes );
		$html->isVirtual = true;
		$this->stack->push( $html );
	}

	public function startDocument() {
		$this->handler->startDocument();
	}

	public function registerTokenizer( Tokenizer $tokenizer ) {
		$tokenizer->setEnableCdataCallback(
			function () {
				$acn = $this->adjustedCurrentNode();
				return $acn && $acn->namespace !== HTMLData::NS_HTML;
			}
		);
		$this->tokenizer = $tokenizer;
	}

	/**
	 * Get the adjusted current node
	 * @return Element|null
	 */
	public function adjustedCurrentNode() {
		$current = $this->stack->current;
		if ( $this->isFragment && ( !$current || $current->stackIndex === 0 ) ) {
			return $this->fragmentContext;
		} else {
			return $current;
		}
	}

	private function appropriatePlace( $target = null ) {
		$stack = $this->stack;
		if ( $target === null ) {
			$target = $stack->current;
		}
		if ( $target === null ) {
			return [ self::ROOT, null ];
		}
		if ( $target->isVirtual ) {
			return [ self::ROOT, null ];
		}
		if ( !$this->fosterParenting ) {
			return [ self::BELOW, $target ];
		}
		if ( !isset( self::$fosterTriggers[$target->htmlName] ) ) {
			return [ self::BELOW, $target ];
		}
		$node = null;
		for ( $idx = $this->stack->length() - 1; $idx >= 0; $idx-- ) {
			$node = $this->stack->item( $idx );
			if ( $node->htmlName === 'table' && $idx >= 1 ) {
				return [ self::BEFORE, $node ];
			}
			if ( $node->htmlName === 'template' ) {
				return [ self::BELOW, $node ];
			}
		}
		if ( $this->isFragment ) {
			return [ self::ROOT, null ];
		} else {
			return [ self::BELOW, $node ];
		}
	}

	public function insertCharacters( $text, $start, $length, $sourceStart, $sourceLength ) {
		list( $prep, $ref ) = $this->appropriatePlace();
		$this->handler->characters( $prep, $ref, $text, $start, $length,
			$sourceStart, $sourceLength );
	}

	public function insertElement( $name, Attributes $attrs, $void, $sourceStart, $sourceLength ) {
		return $this->insertForeign( HTMLData::NS_HTML, $name, $attrs, $void,
			$sourceStart, $sourceLength );
	}

	public function insertForeign( $ns, $name, Attributes $attrs, $void,
		$sourceStart, $sourceLength
	) {
		list( $prep, $ref ) = $this->appropriatePlace();
		$element = new Element( $ns, $name, $attrs );
		$this->handler->insertElement( $prep, $ref, $element, $void,
			$sourceStart, $sourceLength );
		if ( !$void ) {
			$this->stack->push( $element );
		}
		return $element;
	}

	/**
	 * Pop the current node from the stack of open elements, and notify the
	 * handler that we are done with that node.
	 */
	public function pop( $sourceStart, $sourceLength ) {
		$element = $this->stack->pop();
		$this->handler->endTag( $element, $sourceStart, $sourceLength );
		return $element;
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->handler->doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength );
		$this->quirks = $quirks;
	}

	public function comment( $place, $text, $sourceStart, $sourceLength ) {
		list( $prep, $ref ) = $place !== null ? $place : $this->appropriatePlace();
		$this->handler->comment( $prep, $ref, $text, $sourceStart, $sourceLength );
	}

	public function error( $text, $pos ) {
		if ( !$this->ignoreErrors ) {
			$this->handler->error( $text, $pos );
		}
	}

	public function mergeAttributes( Element $elt, Attributes $attrs, $sourceStart, $sourceLength ) {
		if ( $attrs->count() && !$elt->isVirtual ) {
			$this->handler->mergeAttributes( $elt, $attrs, $sourceStart, $sourceLength );
		}
	}

	public function closePInButtonScope( $pos ) {
		if ( $this->stack->isInButtonScope( 'p' ) ) {
			$this->generateImpliedEndTagsAndPop( 'p', $pos, 0 );
		}
	}

	/**
	 * Check the stack to see if there is any element which is not on the list
	 * of allowed elements. Raise an error if any are found.
	 *
	 * @param array $allowed An array with the HTML element names in the key
	 */
	public function checkUnclosed( $allowed, $pos ) {
		$stack = $this->stack;
		for ( $i = $stack->length() - 1; $i >= 0; $i-- ) {
			$unclosedName = $stack->item( $i )->htmlName;
			if ( !isset( $allowed[$unclosedName] ) ) {
				$this->error( "closing unclosed <$unclosedName>", $pos );
			}
		}
	}

	/**
	 * Reconstruct the active formatting elements.
	 * @author C. Scott Ananian, Tim Starling
	 */
	public function reconstructAFE( $sourceStart ) {
		$entry = $this->afe->getTail();
		// If there are no entries in the list of active formatting elements,
		// then there is nothing to reconstruct
		if ( !$entry ) {
			return;
		}
		// If the last is a marker, do nothing.
		if ( $entry instanceof Marker ) {
			return;
		}
		// Or if it is an open element, do nothing.
		if ( $entry->stackIndex !== null ) {
			return;
		}

		// Loop backward through the list until we find a marker or an
		// open element
		$foundIt = false;
		while ( $entry->prevAFE ) {
			$entry = $entry->prevAFE;
			if ( $entry instanceof Marker || $entry->stackIndex !== null ) {
				$foundIt = true;
				break;
			}
		}

		// Now loop forward, starting from the element after the current one (or
		// the first element if we didn't find a marker or open element),
		// recreating formatting elements and pushing them back onto the list
		// of open elements.
		if ( $foundIt ) {
			$entry = $entry->nextAFE;
		}
		do {
			$newElement = $this->insertForeign( HTMLData::NS_HTML, $entry->name,
				$entry->attrs, false, $sourceStart, 0 );
			$this->afe->replace( $entry, $newElement );
			$entry = $newElement->nextAFE;
		} while ( $entry );
	}

	/**
	 * Run the "adoption agency algorithm" (AAA) for the given subject
	 * tag name.
	 * @author C. Scott Ananian, Tim Starling
	 *
	 * https://www.w3.org/TR/2014/REC-html5-20141028/syntax.html#adoption-agency-algorithm
	 *
	 * @param string $subject The subject tag name.
	 * @param integer $sourceStart
	 * @param integer $sourceLength
	 */
	public function adoptionAgency( $subject, $sourceStart, $sourceLength ) {
		$afe = $this->afe;
		$stack = $this->stack;
		$handler = $this->handler;

		// If the current node is an HTML element whose tag name is subject,
		// and the current node is not in the list of active formatting
		// elements, then pop the current node off the stack of open
		// elements and abort these steps. [1]
		if (
			$stack->current->htmlName === $subject &&
			!$afe->isInList( $stack->current )
		) {
			$this->pop( $sourceStart, $sourceLength );
			return;
		}

		// Outer loop: If outer loop counter is greater than or
		// equal to eight, then abort these steps. [2-4]
		for ( $outer = 0; $outer < 8; $outer++ ) {
			// Let the formatting element be the last element in the list
			// of active formatting elements that: is between the end of
			// the list and the last scope marker in the list, if any, or
			// the start of the list otherwise, and has the same tag name
			// as the token. [5]
			$fmtElt = $afe->findElementByName( $subject );

			// If there is no such node, then abort these steps and instead
			// act as described in the "any other end tag" entry above.
			if ( !$fmtElt ) {
				$this->anyOtherEndTag( $subject, $sourceStart, $sourceLength );
				return;
			}

			// Otherwise, if there is such a node, but that node is not in
			// the stack of open elements, then this is a parse error;
			// remove the element from the list, and abort these steps. [6]
			$fmtEltIndex = $fmtElt->stackIndex;
			if ( $fmtEltIndex === null ) {
				$this->error( 'closing tag matched an active formatting element ' .
					'which is not in the stack', $sourceStart );
				$afe->remove( $fmtElt );
				return;
			}

			// Otherwise, if there is such a node, and that node is also in
			// the stack of open elements, but the element is not in scope,
			// then this is a parse error; ignore the token, and abort
			// these steps. [7]
			if ( !$stack->isElementInScope( $fmtElt ) ) {
				$this->error( 'end tag matched a start tag which is not in scope',
					$sourceStart );
				return;
			}

			// If formatting element is not the current node, this is a parse
			// error. (But do not abort these steps.) [8]
			if ( $fmtElt !== $stack->current ) {
				$this->error( 'end tag matched a formatting element which was ' .
					'not the current node', $sourceStart );
			}

			// Let the furthest block be the topmost node in the stack of
			// open elements that is lower in the stack than the formatting
			// element, and is an element in the special category. There
			// might not be one. [9]
			$furthestBlock = null;
			$furthestBlockIndex = -1;
			$stackLength = $stack->length();
			for ( $i = $fmtEltIndex+1; $i < $stackLength; $i++ ) {
				$item = $stack->item( $i );
				if ( isset( HTMLData::$special[$item->namespace][$item->name] ) ) {
					$furthestBlock = $item;
					$furthestBlockIndex = $i;
					break;
				}
			}

			// If there is no furthest block, then the UA must skip the
			// subsequent steps and instead just pop all the nodes from the
			// bottom of the stack of open elements, from the current node up
			// to and including the formatting element, and remove the
			// formatting element from the list of active formatting
			// elements. [10]
			if ( !$furthestBlock ) {
				$this->popAllUpToElement( $fmtElt, $sourceStart, $sourceLength );
				$afe->remove( $fmtElt );
				return;
			}

			// Let the common ancestor be the element immediately above the
			// formatting element in the stack of open elements. [11]
			$ancestor = $stack->item( $fmtEltIndex - 1 );

			// Let a bookmark note the position of the formatting element in
			// the list of active formatting elements relative to the elements
			// on either side of it in the list. [12]
			$bookmark = new Marker( 'bookmark' );
			$afe->insertAfter( $fmtElt, $bookmark );

			// Let node and last node be the furthest block. [13]
			$lastNode = $furthestBlock;
			$nodeIndex = $furthestBlockIndex;
			$isAFE = false;
			$stackRemovals = [];

			// Inner loop
			for ( $inner = 1; true; $inner++ ) {
				// Let node be the element immediately above node in the stack
				// of open elements, or if node is no longer in the stack of
				// open elements (e.g. because it got removed by this
				// algorithm), the element that was immediately above node in
				// the stack of open elements before node was removed. [13.3]
				$node = $stack->item( --$nodeIndex );

				// If node is the formatting element, then go to the next step
				// in the overall algorithm. [13.4]
				if ( $node === $fmtElt ) {
					break;
				}

				// If the inner loop counter is greater than three and node
				// is in the list of active formatting elements, then remove
				// node from the list of active formatting elements. [13.5]
				$isAFE = $afe->isInList( $node );
				if ( $inner > 3 && $isAFE ) {
					$afe->remove( $node );
					$isAFE = false;
				}

				// If node is not in the list of active formatting elements,
				// then remove node from the stack of open elements and then
				// go back to the step labeled inner loop. [13.6]
				if ( !$isAFE ) {
					$stackRemovals[$nodeIndex] = true;
					continue;
				}

				// Create an element for the token for which the element node
				// was created with common ancestor as the intended parent,
				// replace the entry for node in the list of active formatting
				// elements with an entry for the new element, replace the
				// entry for node in the stack of open elements with an entry
				// for the new element, and let node be the new element. [13.7]
				$newElt = new Element(
					$node->namespace, $node->name, $node->attrs );
				$afe->replace( $node, $newElt );
				$stack->replace( $node, $newElt );
				$handler->endTag( $node );
				$node = $newElt;

				// If last node is the furthest block, then move the
				// aforementioned bookmark to be immediately after the new node
				// in the list of active formatting elements. [13.8]
				if ( $lastNode === $furthestBlock ) {
					$afe->remove( $bookmark );
					$afe->insertAfter( $newElt, $bookmark );
				}

				// Insert last node into node, first removing it from its
				// previous parent node if any. [13.9]
				$handler->reparentNode( $lastNode, $node, $sourceStart );

				// Let last node be node. [13.10]
				$lastNode = $node;
			}

			// Insert whatever last node ended up being in the previous step at
			// the appropriate place for inserting a node, but using common
			// ancestor as the override target. [14]
			list( $prep, $ref ) = $this->appropriatePlace( $ancestor );
			$handler->insertElement( $prep, $ref, $lastNode, false, $sourceStart, 0 );

			// Create an element for the token for which the formatting element
			// was created, with furthest block as the intended parent. [15]
			$newElt2 = new Element(
				$fmtElt->namespace, $fmtElt->name, $fmtElt->attribs );

			// Take all of the child nodes of the furthest block and append
			// them to the element created in the last step. [16]
			$handler->reparentChildren( $furthestBlock, $newElt2, $sourceStart );

			// Append that new element to the furthest block. [17]
			$handler->insertElement( self::BELOW, $furthestBlock, $newElt2, false, $sourceStart, 0 );

			// Remove the formatting element from the list of active formatting
			// elements, and insert the new element into the list of active
			// formatting elements at the position of the aforementioned
			// bookmark. [18]
			$afe->remove( $fmtElt );
			$afe->replace( $bookmark, $newElt2 );

			// Remove the formatting element from the stack of open elements,
			// and insert the new element into the stack of open elements
			// immediately below the position of the furthest block in that
			// stack. [19]

			// Make a temporary stack with the elements we are going to push back in
			$tempStack = [];

			// Stash the elements up to the furthest block
			for ( $index = $stack->length(); $index > $furthestBlockIndex; $index-- ) {
				$tempStack[] = $stack->pop();
			}
			// Add the new element
			$tempStack[] = $newElt2;
			// Stash the elements up to the formatting element
			for ( 0; $index > $fmtEltIndex; $index-- ) {
				$elt = $stack->pop();
				// Drop elements previously marked for removal
				if ( isset( $stackRemovals[$index] ) ) {
					$handler->endTag( $elt, $sourcePos, 0 );
				} else {
					$tempStack[] = $elt;
				}
			}
			// Remove the formatting element
			$elt = $stack->pop();
			$handler->endTag( $elt, $sourcePos, 0 );
			// Reinsert
			foreach ( array_reverse( $tempStack ) as $elt ) {
				$stack->push( $elt );
			}
		}

		return;
	}

	public function anyOtherEndTag( $name, $sourceStart, $sourceLength ) {
		$stack = $this->stack;
		$max = $stack->length() - 1;
		for ( $index = $max; $index >= 0; $index-- ) {
			$node = $stack->item( $index );
			if ( $node->htmlName === $name ) {
				$this->generateImpliedEndTags( $name, $sourceStart );
				// If node is not the current node, then this is a parse error
				if ( $index !== $max ) {
					$this->error( 'end tag matched an element which was not the current node',
						$sourceStart );
				}
				// Pop all the nodes from the current node up to node, including
				// node, then stop these steps.
				for ( $j = $max; $j > $index; $j-- ) {
					$elt = $stack->pop();
					$this->handler->endTag( $elt, $sourceStart, 0 );
				}
				$elt = $stack->pop();
				$this->handler->endTag( $elt, $sourceStart, $sourceLength );
				return;
			}

			// If node is in the special category, then this is a parse error;
			// ignore the token, and abort these steps
			if ( isset( HTMLData::$special[$node->htmlName] ) ) {
				$this->error( "cannot implicitly close a special element <{$node->htmlName}>",
					$sourceStart );
				return;
			}
		}
	}

	/**
	 * Generate implied end tags, optionally with an element to exclude.
	 *
	 * @param string|null $name The name to exclude
	 * @param integer $pos The source position
	 */
	public function generateImpliedEndTags( $name, $pos ) {
		$stack = $this->stack;
		$current = $stack->current;
		while ( $current && $current->htmlName !== $name &&
		  isset( self::$impliedEndTags[$current->htmlName] )
		) {
			$popped = $stack->pop();
			$this->handler->endTag( $popped, $pos, 0 );
			$current = $stack->current;
		}
	}

	/**
	 * Generate implied end tags, with an element to exclude, and if the
	 * current element is not now the named excluded element, raise an error.
	 * Then, pop all elements until an element with the name is popped from
	 * the list.
	 *
	 * @param string $name The name to exclude
	 * @param integer $sourceStart
	 * @param integer $sourceLength
	 */
	public function generateImpliedEndTagsAndPop( $name, $sourceStart, $sourceLength ) {
		$this->generateImpliedEndTags( $name, $sourceStart );
		if ( $this->stack->current->htmlName !== $name ) {
			$this->error( "found </$name> but elements are open that cannot " .
				"have implied end tags, closing them", $sourceStart );
		}
		$this->popAllUpToName( $name, $sourceStart, $sourceLength );
	}

	public function popAllUpToElement( Element $elt, $sourceStart, $sourceLength ) {
		while ( true ) {
			$popped = $this->stack->pop();
			if ( !$popped ) {
				break;
			} elseif ( $popped === $elt ) {
				$this->handler->endTag( $popped, $sourceStart, $sourceLength );
				break;
			} else {
				$this->handler->endTag( $popped, $sourceStart, 0 );
			}
		}
	}

	public function popAllUpToName( $name, $sourceStart, $sourceLength ) {
		while ( true ) {
			$popped = $this->stack->pop();
			if ( !$popped ) {
				break;
			} elseif ( $popped->htmlName === $name ) {
				$this->handler->endTag( $popped, $sourceStart, $sourceLength );
				break;
			} else {
				$this->handler->endTag( $popped, $sourceStart, 0 );
			}
		}
	}

	public function popAllUpToNames( $names, $sourceStart, $sourceLength ) {
		while ( true ) {
			$popped = $this->stack->pop();
			if ( !$popped ) {
				break;
			} elseif ( isset( $names[$popped->htmlName] ) ) {
				$this->handler->endTag( $popped, $sourceStart, $sourceLength );
				break;
			} else {
				$this->handler->endTag( $popped, $sourceStart, 0 );
			}
		}
	}

	/**
	 * The "clear stack back to" algorithm used by several template insertion
	 * modes. Similar to popAllUpToName(), except that the named element is
	 * not popped, and a set of names is used instead of a single name.
	 *
	 * @param array $names
	 * @param integer $pos
	 */
	public function clearStackBack( $names, $pos ) {
		$stack = $this->stack;
		while ( $stack->current && !isset( $names[$stack->current->htmlName] ) ) {
			$this->pop( $pos, 0 );
		}
		if ( !$stack->current ) {
			throw new TreeBuilderError( 'clearStackBack: stack is unexpectedly empty' );
		}
	}

	public function stopParsing( $pos ) {
		$stack = $this->stack;
		while ( $stack->current ) {
			$popped = $stack->pop();
			if ( !$this->isFragment || $popped->htmlName !== 'html' ) {
				$this->handler->endTag( $popped, $pos, 0 );
			}
		}
		$this->handler->endDocument( $pos );
	}
}
