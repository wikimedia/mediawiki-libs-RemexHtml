<?php

namespace RemexHtml\Serializer;
use RemexHtml\TreeBuilder\TreeBuilder;
use RemexHtml\TreeBuilder\TreeHandler;
use RemexHtml\TreeBuilder\Element;
use RemexHtml\Tokenizer\Attributes;
use RemexHtml\Tokenizer\PlainAttributes;

/**
 * A TreeHandler which builds a serialized representation of a document, by
 * encoding elements when the end tags are seen. This is faster than building
 * a DOM and then serializing it, even if you use DOMDocument::saveHTML().
 */
class Serializer implements TreeHandler {
	/**
	 * A node corresponding to the Document
	 * @var SerializerNode
	 */
	private $root;

	/**
	 * The error callback
	 */
	private $errorCallback;

	/**
	 * The Formatter implementation
	 *
	 * @var Formatter
	 */
	private $formatter;

	/**
	 * All active SerializerNode objects in an array, so that they can be
	 * referred to by integer indexes. This is a way to emulate weak references,
	 * to avoid circular references, allowing nodes to be freed.
	 *
	 * @var SerializerNode[integer]
	 */
	private $nodes = [];

	/**
	 * The next key into $nodes which will be created
	 */
	private $nextNodeId = 0;

	/**
	 * True if we are parsing a fragment. The children of the <html> element
	 * will be serialized, instead of the whole document.
	 */
	private $isFragment;

	/**
	 * Constructor
	 *
	 * @param Formatter $formatter
	 * @param callable|null $errorCallback A function which is called with the
	 *   details of each parse error
	 */
	public function __construct( Formatter $formatter, $errorCallback = null ) {
		$this->formatter = $formatter;
		$this->errorCallback = $errorCallback;
	}

	/**
	 * Get the final string. This can only be called after endDocument() is received.
	 */
	public function getResult() {
		return $this->result;
	}

	public function startDocument( $fragmentNamespace, $fragmentName ) {
		$this->root = new SerializerNode( 0, 0, '', '', new PlainAttributes, false );
		$this->nodes = [ $this->root ];
		$this->nextNodeId = 1;
		$this->isFragment = $fragmentNamespace !== null;
		$this->result = $this->formatter->startDocument( $fragmentNamespace, $fragmentName );
	}

	public function endDocument( $pos ) {
		if ( $this->isFragment ) {
			$root = $this->root->children[0];
		} else {
			$root = $this->root;
		}
		foreach ( $root->children as $childIndex => $child ) {
			if ( is_string( $child ) ) {
				$this->result .= $child;
			} else {
				$this->result .= $this->stringify( $child );
			}
		}
		$this->root = null;
	}

	public function characters( $preposition, $refElement, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$encoded = (string)$this->formatter->characters( $text, $start, $length );

		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $this->nodes[$refElement->userData->parentId];
		} else {
			$parent = $refElement->userData;
		}

		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $preposition === TreeBuilder::BEFORE ) {
			// Insert before element
			$refNode = $refElement->userData;
			if ( $lastChild !== $refNode ) {
				$refIndex = array_search( $refNode, $children, true );
				throw new SerializerError( "invalid insert position $refIndex/$lastChildIndex" );
			}
			$children[$lastChildIndex] = $encoded;
			$children[$lastChildIndex + 1] = $refNode;
		} else {
			// Append to the list of children
			if ( is_string( $lastChild ) ) {
				$children[$lastChildIndex] .= $encoded;
			} else {
				$children[] = $encoded;
			}
		}
	}

	public function insertElement( $preposition, $refElement, Element $element, $void,
		$sourceStart, $sourceLength
	) {
		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $this->nodes[$refElement->userData->parentId];
		} else {
			$parent = $refElement->userData;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $element->userData ) {
			// This element has already been inserted, this is a reparenting operation
			$self = $element->userData;
			$oldParent = $this->nodes[$self->parentId];
			$oldChildren =& $oldParent->children;
			$oldChildIndex = array_search( $self, $oldChildren, true );
			if ( $oldChildIndex === false ) {
				throw new SerializerError( "cannot find node to reparent: " .
					$element->getDebugTag() );
			}
			// Remove from the old parent, update parent pointer
			$oldChildren[$oldChildIndex] = '';
			$self->parentId = $parent->id;
		} else {
			// Inserting an element which has not been seen before
			$id = $this->nextNodeId++;
			$self = new SerializerNode( $id, $parent->id, $element->namespace,
				$element->name, $element->attrs, $void );
			$this->nodes[$id] = $element->userData = $self;
		}

		if ( $preposition === TreeBuilder::BEFORE ) {
			// Insert before element
			$refNode = $refElement->userData;
			if ( $lastChild !== $refNode ) {
				$refIndex = array_search( $refNode, $children, true );
				throw new SerializerError( "invalid insert position $refIndex/$lastChildIndex" );
			}
			$children[$lastChildIndex] = $self;
			$children[$lastChildIndex + 1] = $refNode;
		} else {
			// Append to the list of children
			$children[] = $self;
		}
	}

	public function endTag( Element $element, $sourceStart, $sourceLength ) {
		if ( $element->htmlName === 'head' || $element->isVirtual ) {
			// <head> elements are immortal
			return;
		}
		$self = $element->userData;
		$parent = $this->nodes[$self->parentId];
		$children =& $parent->children;
		for ( $index = count( $children ) - 1; $index >= 0; $index-- ) {
			if ( $children[$index] === $self ) {
				unset( $this->nodes[$self->id] );
				$children[$index] = $this->stringify( $self );
				return;
			}
		}
		// Ignore requests to end non-existent elements (this happens sometimes)
	}

	/**
	 * Serialize a specific node
	 *
	 * @param SerializerNode $node
	 * @return string
	 */
	private function stringify( SerializerNode $node ) {
		if ( $node->void ) {
			$contents = null;
		} else {
			$contents = '';
			foreach ( $node->children as $childIndex => $child ) {
				if ( is_string( $child ) ) {
					$contents .= $child;
				} else {
					$contents .= $this->stringify( $child );
				}
			}
		}
		return $this->formatter->element( $node->namespace, $node->name,
			$node->attrs, $contents );
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->result .= $this->formatter->doctype( $name, $public, $system );
	}

	public function comment( $preposition, $refElement, $text, $sourceStart, $sourceLength ) {
		$encoded = $this->formatter->comment( $text );
		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $this->nodes[$refElement->userData->parentId];
		} else {
			$parent = $refElement->userData;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $preposition === TreeBuilder::BEFORE ) {
			// Insert before element
			$refNode = $refElement->userData;
			if ( $lastChild !== $refNode ) {
				throw new SerializerError( "invalid insert position" );
			}
			$children[$lastChildIndex] = $encoded;
			$children[$lastChildIndex + 1] = $refNode;
		} else {
			// Append to the list of children
			if ( is_string( $lastChild ) ) {
				$children[$lastChildIndex] .= $encoded;
			} else {
				$children[] = $encoded;
			}
		}
	}

	public function error( $text, $pos ) {
		if ( $this->errorCallback ) {
			call_user_func( $this->errorCallback, $text, $pos );
		}
	}

	public function mergeAttributes( Element $element, Attributes $attrs, $sourceStart ) {
		$element->attrs->merge( $attrs );
		if ( $element->userData instanceof SerializerNode ) {
			$element->userData->attrs = $element->attrs;
		}
	}

	public function removeNode( Element $element, $sourceStart ) {
		$self = $element->userData;
		$parent = $this->nodes[$self->parentId];
		$children =& $parent->children;
		for ( $index = count( $children ) - 1; $index >= 0; $index-- ) {
			if ( $children[$index] === $self ) {
				$children[$index] = '';
				return;
			}
		}
		throw new SerializerError( "cannot find element to remove" );
	}

	public function reparentChildren( Element $element, Element $newParent, $sourceStart ) {
		$self = $element->userData;
		$children = $self->children;
		$self->children = [];
		$this->insertElement( TreeBuilder::UNDER, $element, $newParent, false, $sourceStart, 0 );
		$newParentNode = $newParent->userData;
		$newParentId = $newParentNode->id;
		foreach ( $children as $child ) {
			if ( is_object( $child ) ) {
				$child->parentId = $newParentId;
			}
		}
		$newParentNode->children = $children;
	}

	/**
	 * Get a text representation of the current state of the serializer, for
	 * debugging.
	 *
	 * @return string
	 */
	public function dump() {
		$s = $this->stringify( $this->root );
		return substr( $s, 2, -3 ) . "\n";
	}
}
