<?php

namespace Wikimedia\RemexHtml\Balancer;

class ForeignAttribute {
	public $name;
	public $value;

	private static $allowedVars = [
		'namespaceURI' => true,
		'prefix' => true,
		'localName' => true
	];

	private static $namespaceMap = [
		'xlink:actuate' => HTMLData::NS_XLINK,
		'xlink:arcrole' => HTMLData::NS_XLINK,
		'xlink:href' => HTMLData::NS_XLINK,
		'xlink:role' => HTMLData::NS_XLINK,
		'xlink:show' => HTMLData::NS_XLINK,
		'xlink:title' => HTMLData::NS_XLINK,
		'xlink:type' => HTMLData::NS_XLINK,
		'xml:base' => HTMLData::NS_XML,
		'xml:lang' => HTMLData::NS_XML,
		'xml:space' => HTMLData::NS_XML,
		'xmlns' => HTMLData::NS_XMLNS,
		'xmlns:xlink' => HTMLData::NS_XMLNS,
	];

	public function __get( $var ) {
		if ( !isset( self::$allowedVars[$var] ) ) {
			trigger_error( "ForeignAttribute: no such property \"$var\"", E_USER_WARNING );
			return null;
		}
		$this->init();
		return $this->$var;
	}

	public function __isset( $var ) {
		return isset( self::$allowedVars[$var] );
	}

	private function init() {
		if ( isset( self::$namespaceMap[$this->name] ) ) {
			$this->namespaceURI = self::$adjustmentMap[$this->name];
			$bits = explode( ':', $this->name );
			if ( count( $bits ) > 1 ) {
				$this->prefix = $bits[0];
				$this->localName = $bits[1];
			} else {
				$this->prefix = null;
				$this->localName = $this->name;
			}
		} else {
			$this->namespaceURI = null;
			$this->prefix = null;
			$this->localName = $this->name;
		}
	}
}
