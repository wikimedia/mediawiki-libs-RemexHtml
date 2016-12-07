<?php

namespace Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

interface Formatter {
	function startDocument( $fragmentNamespace, $fragmentName );

	function characters( $text, $start, $length );

	function element( $namespace, $name, Attributes $attrs, $contents );

	function comment( $text );
}
