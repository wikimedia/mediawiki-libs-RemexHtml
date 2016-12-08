<?php

namespace RemexHtml\Serializer;
use RemexHtml\Tokenizer\Attributes;

/**
 * The interface for classes that help Serializer to convert nodes to strings.
 * Serializer assumes that the return values of these functions can be
 * concatenated to make a document.
 *
 * It is not safe to assume that the methods will be called in any particular
 * order, or that the return values will actually be retained in the final
 * Serializer result.
 */
interface Formatter {
	/**
	 * Get a string which starts the document
	 *
	 * @param string|null $fragmentNamespace
	 * @param string|null $fragmentName
	 * @return string
	 */
	function startDocument( $fragmentNamespace, $fragmentName );

	/**
	 * Encode the given character substring
	 *
	 * @param string $text
	 * @param integer $start The offset within $text
	 * @param integer $length The number of bytes within $text
	 * @return string
	 */
	function characters( $text, $start, $length );

	/**
	 * Encode the given element
	 *
	 * @param string $namespace The namespace
	 * @param string $name The tag name
	 * @param Attributes $attrs The attributes
	 * @param string|null The previously-encoded contents, or null for a void
	 *   element. Void elements can be serialized as self-closing tags.
	 *   Occasionally a self-closing tag is technically required for safe
	 *   round-tripping.
	 * @return string
	 */
	function element( $namespace, $name, Attributes $attrs, $contents );

	/**
	 * Encode a comment
	 * @param string $text The inner text of the comment
	 * @return string
	 */
	function comment( $text );
}
