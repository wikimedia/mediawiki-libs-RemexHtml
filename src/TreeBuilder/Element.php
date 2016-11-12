<?php

namespace Wikimedia\RemexHtml\TreeBuilder;

class Element {
	public $namespace;
	public $name;
	public $htmlName;
	public $attrs;
	public $attrObjects;

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
	}

	public function isMathmlTextIntegration() {
		return $this->namespace === HTMLData::NS_MATHML
			&& isset( self::$mathmlIntegration[$this->name] );
	}

	public function isHtmlIntegration() {
		if ( $this->namespace === HTMLData::NS_MATHML ) {
			$encoding = strtolower( $attrs['encoding'] );
			return $encoding === 'text/html' || $encoding === 'application/xhtml+xml';
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
			$attrs = $this->attrs->getArrayCopy();
			ksort( $attrs );
			$this->noahKey = serialize( [ $this->htmlName, $attrs ] );
		}
		return $this->noahKey;
	}

	/**
	 * Get an array of objects representing the namespaced attributes
	 */
	public function getAttributeObjects() {
		if ( $this->attrs instanceof ForeignAttributes ) {
			$this->attrObjects = $this->attrs->createAttributeObjects();
		} else {
			$result = [];
			foreach ( $this->attrs as $name => $value ) {
				$result[] = new Attribute( $name, null, null, $name, $value );
			}
			$this->attrObjects = $result;
		}
		return $this->attrObjects;
	}
}
