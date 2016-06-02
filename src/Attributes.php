<?php

namespace Wikimedia\RemexHtml;

/**
 * Interface for attributes emitted by the tokenizer
 */
interface Attributes extends \ArrayAccess {
	/**
	 * Get the attributes as an array
	 * @return array
	 */
	function getArrayCopy();

	/**
	 * Get the number of attributes. This may include duplicates, and so may
	 * be larger than count( $this->getArrayCopy() ). Including duplicates
	 * gives us an efficient way to distinguish zero attributes from non-zero
	 * but is not compliant with the spec, which states that duplicate
	 * attributes must be removed.
	 */
	function count();
}
