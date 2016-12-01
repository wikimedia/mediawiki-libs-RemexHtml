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

	public function dump() {
		$s = '';
		for ( $i = 0; $i < $this->length(); $i++ ) {
			$item = $this->item( $i );
			$s .= "$i. " . $item->getDebugTag();
			if ( $i === $this->length() - 1 && $item !== $this->current ) {
				$s .= " CURRENT POINTER INCORRECT";
			}
			$s .= "\n";
		}
		return $s;
	}
}
