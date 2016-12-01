<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\TreeBuilder\TreeBuilder;
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

	public function characters( $preposition, $refElement, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$encoded = (string)$this->formatter->characters( $text, $start, $length );

		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $refElement->userData->parent;
		} else {
			$parent = $refElement->userData->self;
		}

		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $preposition === TreeBuilder::BEFORE ) {
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

	public function insertElement( $preposition, $refElement, Element $element, $void,
		$sourceStart, $sourceLength
	) {
		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $refElement->userData->parent;
		} else {
			$parent = $refElement->userData->self;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		$self = new SerializerNode( $element->namespace, $element->name, $element->attrs, $void );

		if ( $preposition === TreeBuilder::BEFORE ) {
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
		if ( $element->htmlName === 'head' || $element->isVirtual ) {
			// <head> elements are immortal
			return;
		}
		$parent = $element->userData->parent;
		$self = $element->userData->self;
		$children =& $parent->children;
		for ( $index = count( $children ) - 1; $index >= 0; $index-- ) {
			if ( $children[$index] === $self ) {
				$this->flatten( $parent, $index, $self );
				return;
			}
		}
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

	public function comment( $preposition, $refElement, $text, $sourceStart, $sourceLength ) {
		$encoded = $this->formatter->comment( $text );
		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->root;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $refElement->userData->parent;
		} else {
			$parent = $refElement->userData->self;
		}
		$children =& $parent->children;
		$lastChildIndex = count( $children ) - 1;
		$lastChild = $lastChildIndex >= 0 ? $children[$lastChildIndex] : null;

		if ( $preposition === TreeBuilder::BEFORE ) {
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
		$element->attrs->merge( $attrs );
		if ( $element->userData instanceof SerializerNode ) {
			$element->userData->self->attrs = $element->attrs;
		}
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
