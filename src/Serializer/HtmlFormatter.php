<?php

namespace RemexHtml\Serializer;
use RemexHtml\HTMLData;

/**
 * A formatter which follows the HTML 5 fragment serialization algorithm.
 */
class HtmlFormatter implements Formatter {
	/**
	 * The elements for which a closing tag is omitted.
	 */
	protected $voidElements = [
		'area' => true,
		'base' => true,
		'basefont' => true,
		'bgsound' => true,
		'br' => true,
		'col' => true,
		'embed' => true,
		'frame' => true,
		'hr' => true,
		'img' => true,
		'input' => true,
		'keygen' => true,
		'link' => true,
		'meta' => true,
		'param' => true,
		'source' => true,
		'track' => true,
		'wbr' => true
	];

	/**
	 * The elements which need a leading newline in their contents to be
	 * duplicated, since the parser strips a leading newline.
	 */
	protected $prefixLfElements = [
		'pre' => true,
		'textarea' => true,
		'listing' => true
	];

	/**
	 * The elements which have unescaped contents.
	 */
	protected $rawTextElements = [
		'style' => true,
		'script' => true,
		'xmp' => true,
		'iframe' => true,
		'noembed' => true,
		'noframes' => true,
		'plaintext' => true,
	];
	/**
	 * The escape table for attribute values
	 */
	protected $attributeEscapes = [
		'&' => '&amp;',
		"\xc2\xa0" => '&nbsp;',
		'"' => '&quot;',
	];
	/**
	 * The escape table for text nodes
	 */
	protected $textEscapes = [
		'&' => '&amp;',
		"\xc2\xa0" => '&nbsp;',
		'<' => '&lt;',
		'>' => '&gt;',
	];

	/**
	 * The scripting flag, which is true if scripting is enabled. This influences
	 * <noscript> serialization.
	 */
	protected $scriptingFlag;

	/**
	 * Constructor.
	 *
	 * @param array $options An associative array of options:
	 *   - scriptingFlag : Set this to false to disable scripting. True by default.
	 */
	public function __construct( $options = [] ) {
		$options += [
			'scriptingFlag' => true
		];
		if ( $options['scriptingFlag'] ) {
			$this->rawTextElements['noscript'] = true;
		}
	}

	public function startDocument( $fragmentNamespace, $fragmentName ) {
		return "<!DOCTYPE html>\n";
	}

	public function characters( SerializerNode $parent, $text, $start, $length ) {
		$text = substr( $text, $start, $length );
		if ( $parent->namespace !== HTMLData::NS_HTML
			|| !isset( $this->rawTextElements[$parent->name] )
		) {
			$text = strtr( $text, $this->textEscapes );
		}
		return $text;
	}

	public function element( SerializerNode $parent, SerializerNode $node, $contents ) {
		$name = $node->name;
		$s = "<$name";
		foreach ( $node->attrs->getValues() as $attrName => $attrValue ) {
			$encValue = strtr( $attrValue, $this->attributeEscapes );
			$s .= " $attrName=\"$encValue\"";
		}
		$s .= '>';
		if ( $node->namespace === HTMLData::NS_HTML ) {
			if ( isset( $contents[0] ) && $contents[0] === "\n"
				&& isset( $this->prefixLfElements[$name] )
			) {
				$s .= "\n$contents</$name>";
			} elseif ( !isset( $this->voidElements[$name] ) ) {
				$s .= "$contents</$name>";
			}
		} else {
			$s .= "$contents</$name>";
		}
		return $s;
	}

	public function comment( SerializerNode $parent, $text ) {
		return "<!--$text-->";
	}

	public function doctype( $name, $public, $system ) {
		return '';
	}
}
