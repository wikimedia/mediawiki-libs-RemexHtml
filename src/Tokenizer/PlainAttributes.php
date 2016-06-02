<?php

namespace Wikimedia\RemexHtml\Tokenizer;

/**
 * An Attributes implementation which is a simple array proxy.
 *
 * Now you see why I called the array accessor getArrayCopy(). It's
 * called PlainAttributes but really it is just an ArrayObject in disguise.
 */
class PlainAttributes extends \ArrayObject implements Attributes  {
}
