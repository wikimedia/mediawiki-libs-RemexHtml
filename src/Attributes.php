<?php

namespace Wikimedia\RemexHtml;

interface Attributes extends \ArrayAccess {
	function getArrayCopy();
	function count();
}
