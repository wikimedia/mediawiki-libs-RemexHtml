<?php

namespace Wikimedia\RemexHtml\Tokenizer;

/**
 * An Attributes implementation which defers interpretation of regex match
 * results until the caller requires them.
 *
 * This should not be directly instantiated outside of Tokenizer.
 */
class LazyAttributes implements Attributes {
	private $tokenizer;
	private $data;
	private $attributes;

	public function __construct( $data, callable $interpreter ) {
		$this->interpreter = $interpreter;
		$this->data = $data;
	}

	private function init() {
		if ( $this->attributes === null ) {
			$func = $this->interpreter;
			$this->attributes = $func( $this->data );
			$this->interpreter = null;
		}
	}

	public function offsetExists( $offset ) {
		if ( $this->attributes === null ) {
			$this->init();
		}
		return isset( $this->attributes[$offset] );
	}

	public function &offsetGet( $offset ) {
		if ( $this->attributes === null ) {
			$this->init();
		}
		return $this->attributes[$offset];
	}

	public function offsetSet( $offset, $value ) {
		if ( $this->attributes === null ) {
			$this->init();
		}
		$this->attributes[$offset] = $value;
	}

	public function offsetUnset( $offset ) {
		if ( $this->attributes === null ) {
			$this->init();
		}
		unset( $this->attributes[$offset] );
	}

	public function getArrayCopy() {
		if ( $this->attributes === null ) {
			$this->init();
		}
		return $this->attributes;
	}

	public function count() {
		return is_object( $this->data ) ? $this->data->count() : count( $this->data );
	}
}
