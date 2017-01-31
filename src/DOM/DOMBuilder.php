<?php

namespace RemexHtml\DOM;
use RemexHtml\Tokenizer\Attributes;
use RemexHtml\TreeBuilder\Element;
use RemexHtml\TreeBuilder\TreeBuilder;
use RemexHtml\TreeBuilder\TreeHandler;

/**
 * A TreeHandler which constructs a DOMDocument
 */
class DOMBuilder implements TreeHandler {
	private $doc;
	private $errorCallback;
	private $isFragment;

	public $doctypeName;
	public $public;
	public $system;
	public $quirks;

	/**
	 * @param callable|null $errorCallback A function which is called on parse errors
	 */
	public function __construct( $errorCallback = null ) {
		$this->errorCallback = $errorCallback;
	}

	/**
	 * Get the constructed document or document fragment. In the fragment case,
	 * a DOMElement is returned, and the caller is expected to extract its
	 * inner contents, ignoring the wrapping element. This convention is
	 * convenient because the wrapping element gives libxml somewhere to put
	 * its namespace declarations. If we copied the children into a
	 * DOMDocumentFragment, libxml would invent new prefixes for the orphaned
	 * namespaces.
	 *
	 * @return DOMNode
	 */
	public function getFragment() {
		if ( $this->isFragment ) {
			return $this->doc->documentElement;
		} else {
			return $this->doc;
		}
	}

	public function startDocument( $fragmentNamespace, $fragmentName ) {
		$impl = new \DOMImplementation;
		$this->isFragment = $fragmentNamespace !== null;
		$this->doc = $this->createDocument();
	}

	private function createDocument( $doctypeName = null, $public = null, $system = null ) {
		$impl = new \DOMImplementation;
		if ( $doctypeName === null
			|| $doctypeName === '' // libxml limitation, causes test failures
		) {
			$doc = $impl->createDocument( null, null );
		} else {
			$doctype = $impl->createDocumentType( $doctypeName, $public, $system );
			$doc = $impl->createDocument( null, null, $doctype );
		}
		$doc->encoding = 'UTF-8';
		return $doc;
	}

	public function endDocument( $pos ) {
	}

	private function insertNode( $preposition, $refElement, $node ) {
		if ( $preposition === TreeBuilder::ROOT ) {
			$parent = $this->doc;
			$refNode = null;
		} elseif ( $preposition === TreeBuilder::BEFORE ) {
			$parent = $refElement->userData->parentNode;
			$refNode = $refElement->userData;
		} else {
			$parent = $refElement->userData;
			$refNode = null;
		}
		$parent->insertBefore( $node, $refNode );
	}

	private function createNode( Element $element ) {
		$node = $this->doc->createElementNS(
			$element->namespace,
			$element->name );

		foreach ( $element->attrs->getObjects() as $attr ) {
			if ( $attr->namespaceURI === null
				&& strpos( $attr->localName, ':' ) !== false
			) {
				// FIXME: this apparently works to create a prefixed localName
				// in the null namespace, but this is probably taking advantage
				// of a bug in PHP's DOM library, and screws up in various
				// interesting ways. For example, attributes created in this
				// way can't be discovered via hasAttribute() or hasAttributeNS().
				$attrNode = $this->doc->createAttribute( $attr->localName );
				$attrNode->value = $attr->value;
				$node->setAttributeNodeNS( $attrNode );
			} else {
				$node->setAttributeNS(
					$attr->namespaceURI,
					$attr->qualifiedName,
					$attr->value );
			}
		}
		$element->userData = $node;
		return $node;
	}

	public function characters( $preposition, $refElement, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$node = $this->doc->createTextNode( substr( $text, $start, $length ) );
		$this->insertNode( $preposition, $refElement, $node );
	}

	public function insertElement( $preposition, $refElement, Element $element, $void,
		$sourceStart, $sourceLength
	) {
		if ( $element->userData ) {
			$node = $element->userData;
		} else {
			$node = $this->createNode( $element );
		}
		$this->insertNode( $preposition, $refElement, $node );
	}

	public function endTag( Element $element, $sourceStart, $sourceLength ) {
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		if ( !$this->doc->firstChild ) {
			$impl = $this->doc->implementation;
			$this->doc = $this->createDocument( $name, $public, $system );
		}
		$this->doctypeName = $name;
		$this->public = $public;
		$this->system = $system;
		$this->quirks = $quirks;
	}

	public function comment( $preposition, $refElement, $text, $sourceStart, $sourceLength ) {
		$node = $this->doc->createComment( $text );
		$this->insertNode( $preposition, $refElement, $node );
	}

	public function error( $text, $pos ) {
		if ( $this->errorCallback ) {
			call_user_func( $this->errorCallback, $text, $pos );
		}
	}

	public function mergeAttributes( Element $element, Attributes $attrs, $sourceStart ) {
		$node = $element->userData;
		foreach ( $attrs->getObjects() as $name => $attr ) {
			if ( $attr->namespaceURI === null
				&& strpos( $attr->localName, ':' ) !== false
			) {
				// As noted in createNode(), we can't use hasAttribute() here.
				// However, we can use the return value of setAttributeNodeNS()
				// instead.
				$attrNode = $this->doc->createAttribute( $attr->localName );
				$attrNode->value = $attr->value;
				$replaced = $node->setAttributeNodeNS( $attrNode );
				if ( $replaced ) {
					// Put it back how it was
					$node->setAttributeNodeNS( $replaced );
				}
			} elseif ( $attr->namespaceURI === null ) {
				if ( !$node->hasAttribute( $attr->localName ) ) {
					$node->setAttribute( $attr->localName, $attr->value );
				}
			} elseif ( !$node->hasAttributeNS( $attr->namespaceURI, $attr->localName ) ) {
				$node->setAttributeNS( $attr->namespaceURI, $attr->localName, $attr->value );
			}
		}
	}

	public function removeNode( Element $element, $sourceStart ) {
		$node = $element->userData;
		$node->parentNode->removeChild( $node );
	}

	public function reparentChildren( Element $element, Element $newParent, $sourceStart ) {
		$this->insertElement( TreeBuilder::UNDER, $element, $newParent, false, $sourceStart, 0 );
		$node = $element->userData;
		$newParentNode = $newParent->userData;
		while ( $node->firstChild !== $newParentNode ) {
			$newParentNode->appendChild( $node->firstChild );
		}
	}
}
