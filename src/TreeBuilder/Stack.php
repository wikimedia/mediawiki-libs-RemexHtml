<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

abstract class Stack {
	public $current;

	abstract public function push( Element $elt );
	abstract public function pop();
	abstract public function replace( Element $old, Element $new );
	abstract public function remove( Element $elt );
	abstract public function isInScope( $name );
	abstract public function isElementInScope( Element $elt );
	abstract public function isOneOfSetInScope( $names );
	abstract public function isInListScope( $name );
	abstract public function isInButtonScope( $name );
	abstract public function isInTableScope( $name );
	abstract public function isInSelectScope( $name );
	abstract public function item( $idx );
	abstract public function length();
	abstract public function hasTemplate();
}
