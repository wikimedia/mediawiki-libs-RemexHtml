<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class TestTreeBuilderHandler implements TreeBuilderHandler {
	protected $root;
	protected $doctype = '';
	protected $errors = '';
	protected $lineLengths;

	private static $designators = [
		HTMLData::NS_SVG => 'svg ',
		HTMLData::NS_MATHML => 'math ',
		HTMLData::NS_XLINK => 'xlink ',
		HTMLData::NS_XML => 'xml ',
		HTMLData::NS_XMLNS => 'xmlns ' ];

	public function __construct( $input ) {
		$this->lineLengths = [];
		foreach ( explode( "\n", $input ) as $line ) {
			$this->lineLengths[] = strlen( $line ) + 1;
		}
	}


	public function getDocument() {
		return $this->serializeSubtree( '| ', $parent );
	}

	private function serializeSubtree( $indent, $parent ) {
		$s = "{$indent}<{$parent->name}>\n";
		asort( $parent->attrs );
		foreach ( $parent->attrs as $name => $value ) {
			$s .= "$indent $name=\"$value\"\n";
		}
		foreach ( $parent->childNodes as $child ) {
			if ( is_string( $child ) {
				$s .= "$indent $child\n";
			} else {
				$s .= $this->serializeSubtree( "$indent ", $child );
			}
		}
		return $s;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function startDocument() {
	}

	public function endDocument() {
	}

	public function characters( $parent, $text, $start, $length, $sourceStart, $sourceLength ) {
		$parent->childNodes[] = '"' . substr( $text, $start, $length ) . '"';
	}

	public function insertElement( $parent, $ns, $name, Attributes $attrs,
		$selfClose, $sourceStart, $sourceLength
	) {
		$node = $this->createNode( $ns, $name, $attrs );
		if ( !$parent ) {
			$this->root = $node;
		} else {
			$parent->childNodes[] = $node;
		}
		return $node;
	}

	private function createNode( $ns, $name, Attributes $attrs ) {
		$node = new stdClass;
		if ( strlen( $ns ) ) {
			$node->name = self::$designators[$ns] . $name;
		} else {
			$node->name = $name;
		}
		$attrArray = [];
		foreach ( $attrs as $name => $attr ) {
			if ( is_string( $attr ) ) {
				$attrArray[$name] = $attr;
			} else {
				if ( strlen( $attr->namespaceURI ) ) {
					$nameString = self::$designators[$attr->namespaceURI] . $attr->localName;
				} else {
					$nameString = $attr->name;
				}
				$attrArray[$nameString] = $attr->value;
			}
		}

		$node->attrs = $attrArray;
		$node->childNodes = [];
		return $node;
	}

	public function endTag( $node, $prefix, $name, $sourceStart, $sourceLength )  {
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->doctype = '<!DOCTYPE ';
		if ( strlen( $public ) || strlen( $system ) ) {
			$this->doctype .= "\"$public\" \"$system\"";
		}
		$this->doctype .= '>';
	}

	public function comment( $parent, $text, $sourceStart, $sourceLength ) {
		$parent->childNodes[] = "<!-- $text -->";
	}

	public function error( $text, $pos ) {
		$linePos = 0;
		foreach ( $lineLengths as $lineNumber => $length ) {
			$linePos += $length;
			if ( $pos < $linePos ) {
				break;
			}
		}
		$lineOffset = $pos - $linePos + 1;
		$lineNumber++;

		$this->errors .= "($lineNumber,$lineOffset) $text\n";
	}

	public function mergeAttributes( $node, $name, Attributes $attrs, $sourceStart ) {
		foreach ( $attrs as $name => $attr ) {
			if ( is_string( $attr ) ) {
				$node->attrs[$name] = $attr;
			} else {
				if ( strlen( $attr->prefix ) ) {
					$nameString = "{$attr->prefix} {$attr->name}";
				} else {
					$nameString = $attr->name;
				}
				if ( !isset( $node->attrs[$nameString] ) ) {
					$node->attrs[$nameString] = $attr->value;
				}
			}
		}
	}

	public function removeBody( $sourceStart ) {
		foreach ( $this->root->childNodes as $i => $node ) {
			if ( is_object( $node ) && $node->name === 'body' ) {
				unset( $node->childNodes[$i] );
				break;
			}
		}
	}

	public function reparentNode( $parent, $target, $prefix, $name,
		Attributes $attrs, $sourceStart )
	{
		$node = $this->createNode( $prefix, $name, $attrs );
		$node->childNodes = [ $target ];
		foreach ( $parent->childNodes as $i => $child ) {
			if ( $child === $target ) {
				$parent->childNodes[$i] = $node;
				break;
			}
		}
		return $node;
	}

	public function reparentChildren( $target, $prefix, $name, Attributes $attrs, $sourceStart ) {
		$node = $this->createNode( $prefix, $name, $attrs );
		$node->childNodes = $target->childNodes;
		$target->childNodes = [ $node ];
		return $node;
	}
}

