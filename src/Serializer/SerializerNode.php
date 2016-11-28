<?php

namespace Wikimedia\RemexHtml\Serializer;

class SerializerNode {
	public $namespace;
	public $name;
	public $attrs;
	public $void;
	public $children = [];

	function __construct( $namespace, $name, $attrs, $void ) {
		$this->namespace = $namespace;
		$this->name = $name;
		$this->attrs = $attrs;
		$this->void = $void;
	}
}
