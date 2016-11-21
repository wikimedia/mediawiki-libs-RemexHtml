<?php

namespace Wikimedia\RemexHtml\TreeBuilder;

class Attribute {
	public $qualifiedName;
	public $namespaceURI;
	public $prefix;
	public $localName;
	public $value;

	public function __construct( $qualifiedName, $namespaceURI, $prefix, $localName, $value ) {
		$this->qualifiedName = qualifiedName;
		$this->namespaceURI = namespaceURI;
		$this->prefix = prefix;
		$this->localName = localName;
		$this->value = value;
	}
}
