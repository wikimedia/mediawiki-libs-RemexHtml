<?php

namespace Wikimedia\RemexHtml\Serializer;

class SerializerNode {
	public $id;
	public $parentId;
	public $namespace;
	public $name;
	public $attrs;
	public $void;
	public $children = [];

	public function __construct( $id, $parentId, $namespace, $name, $attrs, $void ) {
		$this->id = $id;
		$this->parentId = $parentId;
		$this->namespace = $namespace;
		$this->name = $name;
		$this->attrs = $attrs;
		$this->void = $void;
	}
}
