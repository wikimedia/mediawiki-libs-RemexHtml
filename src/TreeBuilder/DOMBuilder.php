<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class DOMBuilder implements TreeHandler {
	private $doc;
	private $errorCallback;

	public function __construct( $errorCallback = null ) {
		$this->errorCallback = $errorCallback;
	}

	public function getDocument() {
		return $this->doc;
	}

	public function startDocument() {
		$this->doc = new \DOMDocument;
	}

	public function endDocument( $pos ) {
	}

	public function characters( $parent, $refElement, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$parentNode = $parent ? $parent->userData : $this->doc;
		$refNode = $refElement ? $refElement->userData : null;
		$node = $this->doc->createTextNode( substr( $text, $start, $length ) );
		$parentNode->insertBefore( $node, $refNode );
	}

	public function insertElement( $parent, $refElement, Element $element, $void,
		$sourceStart, $sourceLength
	) {
		$parentNode = $parent ? $parent->userData : $this->doc;
		$refNode = $refElement ? $refElement->userData : null;
		$node = $this->doc->createElementNS(
			$element->namespace,
			$element->name );

		foreach ( $element->getAttributeObjects() as $attr ) {
			if ( $attr->namespaceURI !== null ) {
				$node->setAttributeNS(
					$attr->namespaceURI,
					$attr->qualifiedName,
					$attr->value );
			} else {
				$node->setAttribute( $attr->localName, $attr->value );
			}
		}
		$parentNode->insertBefore( $node, $refNode );
		$element->userData = $node;
	}

	public function endTag( Element $element, $sourceStart, $sourceLength ) {
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
	}

	public function comment( $parent, $refElement, $text, $sourceStart, $sourceLength ) {
		$parentNode = $parent ? $parent->userData : $this->doc;
		$refNode = $refElement ? $refElement->userData : null;
		$node = $this->doc->createComment( $text );
		$parentNode->insertBefore( $node, $refNode );
	}

	public function error( $text, $pos ) {
		if ( $this->errorCallback ) {
			call_user_func( $this->errorCallback, $text, $pos );
		}
	}

	public function mergeAttributes( Element $element, Attributes $attrs, $sourceStart ) {
		$node = $element->userData;
		foreach ( $attrs->getArrayCopy() as $name => $value ) {
			if ( !$node->hasAttribute( $name ) ) {
				$node->setAttribute( $name, $value );
			}
		}
	}

	public function reparentNode( Element $element, Element $newParent, $sourceStart ) {
		$node = $element->userData;
		$newParentNode = $newParent->userData;
		$newParentNode->appendChild( $node );
	}

	public function removeNode( Element $element, $sourceStart ) {
		$node = $element->userData;
		$node->parent->removeChild( $node );
	}

	public function reparentChildren( Element $element, Element $newParent ) {
		$node = $element->userData;
		$newParentNode = $element->userData;
		foreach ( $node->childNodes as $child ) {
			$newParentNode->appendChild( $child );
		}
	}
}
