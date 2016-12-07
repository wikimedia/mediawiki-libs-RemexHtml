<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\HTMLData;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class Element implements FormattingElement {
	public $namespace;
	public $name;
	public $htmlName;
	public $attrs;
	public $isVirtual;

	public $nextScope;
	public $prevAFE, $nextAFE, $nextNoah;
	private $noahKey;

	public $userData;

	private static $mathmlIntegration = [
		'mi' => true,
		'mo' => true,
		'mn' => true,
		'ms' => true,
		'mtext' => true
	];

	private static $svgHtmlIntegration = [
		'foreignObject' => true,
		'desc' => true,
		'title' => true
	];

	public function __construct( $namespace, $name, Attributes $attrs ) {
		$this->namespace = $namespace;
		$this->name = $name;
		if ( $namespace === HTMLData::NS_HTML ) {
			$this->htmlName = $name;
		} elseif ( $namespace === HTMLData::NS_MATHML ) {
			$this->htmlName = "mathml $name";
		} elseif ( $namespace === HTMLData::NS_SVG ) {
			$this->htmlName = "svg $name";
		} else {
			$this->htmlName = "$namespace $name";
		}
		$this->attrs = $attrs;
	}

	public function isMathmlTextIntegration() {
		return $this->namespace === HTMLData::NS_MATHML
			&& isset( self::$mathmlIntegration[$this->name] );
	}

	public function isHtmlIntegration() {
		if ( $this->namespace === HTMLData::NS_MATHML ) {
			if ( isset( $this->attrs['encoding'] ) ) {
				$encoding = strtolower( $this->attrs['encoding'] );
				return $encoding === 'text/html' || $encoding === 'application/xhtml+xml';
			} else {
				return false;
			}
		} elseif ( $this->namespace === HTMLData::NS_SVG ) {
			return isset( self::$svgHtmlIntegration[$this->name] );
		} else {
			return false;
		}
	}

	/**
	 * Get a string key for the Noah's Ark algorithm
	 */
	public function getNoahKey() {
		if ( $this->noahKey === null ) {
			$attrs = $this->attrs->getValues();
			ksort( $attrs );
			$this->noahKey = serialize( [ $this->htmlName, $attrs ] );
		}
		return $this->noahKey;
	}

	public function getDebugTag() {
		return $this->htmlName . '#' . substr( md5( spl_object_hash( $this ) ), 0, 8 );
	}
}