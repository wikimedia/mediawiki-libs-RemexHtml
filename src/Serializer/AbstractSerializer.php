<?php
declare( strict_types = 1 );

namespace Wikimedia\RemexHtml\Serializer;

use Wikimedia\RemexHtml\TreeBuilder\TreeHandler;

interface AbstractSerializer extends TreeHandler {
	/**
	 * Get the serialized result of tree construction
	 *
	 * @return string
	 */
	public function getResult();
}
