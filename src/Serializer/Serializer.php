<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\TreeBuilder\TreeHandler;
use Wikimedia\RemexHtml\TreeBuilder\Element;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\Tokenizer\PlainAttributes;

class Serializer implements TreeHandler {
	private $accumulators;
	private $errorCallback;
	private $numAccums = 1;
	private $formatter;

	public function __construct( Formatter $formatter, $errorCallback = null ) {
		$this->formatter = $formatter;
		$this->errorCallback = $errorCallback;
	}

	public function getResult() {
		return $this->result;
	}

	public function startDocument() {
		$this->root = new SerializerNode( '', '', new PlainAttributes, false );
		$this->result = $this->formatter->startDocument();
	}

	public function endDocument( $pos ) {
		$result = '';
		foreach ( $this->root->children as $childIndex => $child ) {
			if ( is_string( $child ) ) {
				$result .= $child;
			} else {
				$this->flatten( $this->root, $childIndex, $child );
				$result .= $this->root->children[$childIndex];
			}
		}
		$this->result .= $result;
	}

	public function characters( $parentElement, $refElement, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$encoded = (string)$this->formatter->characters( $text, $start, $length );

		if ( $parentElement !== null ) {
			$parent = $parentElement->userData->self;
		} else {
			$parent = $this->root;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $refElement !== null ) {
			// Insert before element
			$refNode = $refElement->userData->self;
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

	public function insertElement( $parentElement, $refElement, Element $element, $void,
		$sourceStart, $sourceLength
	) {
		if ( $parentElement !== null ) {
			$parent = $parentElement->userData->self;
		} else {
			$parent = $this->root;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		$self = new SerializerNode( $element->namespace, $element->name, $element->attrs, $void );

		if ( $refElement !== null ) {
			// Insert before element
			$refNode = $refElement->userData->self;
			if ( $lastChild !== $refNode ) {
				$refIndex = array_search( $refNode, $children, true );
				throw new SerializerError( "invalid insert position $refIndex/$lastChildIndex" );
			}
			$children[$lastChildIndex] = $self;
			$children[$lastChildIndex + 1] = $refNode;
		} else {
			// Append to the list of children
			$parent->children[] = $self;
		}
		$element->userData = new SerializerData( $parent, $self );
	}

	public function endTag( Element $element, $sourceStart, $sourceLength ) {
		$parent = $element->userData->parent;
		$self = $element->userData->self;
		$children =& $parent->children;
		for ( $index = count( $children ) - 1; $index >= 0; $index-- ) {
			if ( $children[$index] === $self ) {
				$this->flatten( $parent, $index, $self );
				return;
			}
		}
		throw new SerializerError( "unable to find an element which is ending" );
	}

	private function flatten( $parent, $selfIndex, $self ) {
		if ( $self->void ) {
			$contents = null;
		} else {
			$contents = '';
			foreach ( $self->children as $childIndex => $child ) {
				if ( is_string( $child ) ) {
					$contents .= $child;
				} else {
					$this->flatten( $self, $childIndex, $child );
					$contents .= $self->children[$childIndex];
				}
			}
		}
		$encoded = $this->formatter->element( $self->namespace, $self->name,
			$self->attrs, $contents );
		$parent->children[$selfIndex] = $encoded;
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->result .= $this->formatter->doctype( $name, $public, $system );
	}

	public function comment( $parentElement, $refElement, $text, $sourceStart, $sourceLength ) {
		$encoded = $this->formatter->comment( $text );
		if ( $parentElement !== null ) {
			$parent = $parentElement->userData->self;
		} else {
			$parent = $this->root;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $refElement !== null ) {
			// Insert before element
			$refNode = $refElement->self;
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
		$element->userData->attrs->merge( $attrs );
	}

	public function reparentNode( Element $element, Element $newParent, $sourceStart ) {
		$parent = $element->userData->parent;
		$self = $element->userData->self;
		$children =& $parent->children;
		for ( $index = count( $children ) - 1; $index >= 0; $index-- ) {
			if ( $children[$index] === $self ) {
				$children[$index] = '';
				$newParent->userData->self->children[] = $self;
				$self->parent = $newParent->userData->self;
				return;
			}
		}
		throw new SerializerError( "cannot find element to reparent" );
	}

	public function removeNode( Element $element, $sourceStart ) {
		$parent = $element->userData->parent;
		$self = $element->userData->self;
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
		$self = $element->userData->self;
		$newParentNode = $newParent->userData->self;
		$newParentNode->children = $self->children;
		$self->children = [];
	}
}
