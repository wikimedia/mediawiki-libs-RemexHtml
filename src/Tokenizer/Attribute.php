<?php

namespace Wikimedia\RemexHtml\Tokenizer;

use Wikimedia\RemexHtml\PropGuard;

/**
 * A namespaced attribute, as returned by Attributes::getObjects()
 */
class Attribute {
	use PropGuard;

	/** @var string */
	public $qualifiedName;
	/** @var string|null */
	public $namespaceURI;
	/** @var string|null */
	public $prefix;
	/** @var string */
	public $localName;
	/** @var mixed */
	public $value;

	public function __construct( $qualifiedName, $namespaceURI, $prefix, $localName, $value ) {
		$this->qualifiedName = $qualifiedName;
		$this->namespaceURI = $namespaceURI;
		$this->prefix = $prefix;
		$this->localName = $localName;
		$this->value = $value;
	}
}
