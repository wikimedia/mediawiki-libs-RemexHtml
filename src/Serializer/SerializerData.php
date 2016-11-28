<?php

namespace Wikimedia\RemexHtml\Serializer;

class SerializerData {
	public $parent;
	public $self;

	public function __construct( SerializerNode $parent, SerializerNode $self ) {
		$this->parent = $parent;
		$this->self = $self;
	}
}
