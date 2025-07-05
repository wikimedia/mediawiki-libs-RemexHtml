<?php

namespace Wikimedia\RemexHtml\Tests\DOM;

use Wikimedia\RemexHtml\DOM\DOMBuilder;
use Wikimedia\RemexHtml\DOM\DOMUtils;
use Wikimedia\RemexHtml\HTMLData;
use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder;

/**
 * @covers \Wikimedia\RemexHtml\DOM\DOMBuilder
 */
class DOMBuilderTest extends \PHPUnit\Framework\TestCase {

	private static function createDoc( $domBuilder ) {
		$domBuilder->startDocument( null, null );
		$domBuilder->doctype( 'html', '', '', TreeBuilder\TreeBuilder::NO_QUIRKS, 0, 0 );
		$noAttributes = new Tokenizer\PlainAttributes( [] );
		$html = new TreeBuilder\Element( HTMLData::NS_HTML, 'html', $noAttributes );
		$domBuilder->insertElement( TreeBuilder\TreeBuilder::ROOT, null, $html, false, 0, 6 );
		$body = new TreeBuilder\Element( HTMLData::NS_HTML, 'body', $noAttributes );
		$domBuilder->insertElement( TreeBuilder\TreeBuilder::UNDER, $html, $body, false, 6, 12 );
		return [ $domBuilder->getFragment(), $body ];
	}

	private function verifyAttribute(
		$doc, string $name, string $value,
		?string $altName, bool $coerced
	) {
		// gently lie to phan about the type of $doc and $domElement
		'@phan-var \DOMDocument $doc';
		$domElement = $doc->documentElement->firstChild->firstChild;
		'@phan-var \DOMElement $domElement';
		$this->assertNotNull( $domElement );
		if ( $altName !== null ) {
			if ( $coerced ) {
				// For coerced attributes, *either* the original name *or*
				// the alternative name (but not both) should be present.
				if ( $domElement->hasAttribute( $altName ) ) {
					$this->assertFalse( $domElement->hasAttribute( $name ) );
					$name = $altName;
				}
			} else {
				if ( !$doc instanceof \DOMDocument ) {
					// For non-coerced attributes with an alternative name, both
					// the original and the alternative name should return the
					// given value.
					$this->assertTrue( $domElement->hasAttribute( $altName ), $altName );
					$this->assertSame( $value, $domElement->getAttribute( $altName ) );
				} else {
					// (this is broken in \DOMDocument, only the altname is set)
					$name = $altName;
				}
			}
		}
		$this->assertTrue( $domElement->hasAttribute( $name ), $name );
		$this->assertSame( $value, $domElement->getAttribute( $name ) );
	}

	/** @dataProvider attributeProvider */
	public function testAttributesCreateNode(
		DOMBuilder $domBuilder, string $name, string $value,
		?string $type = null, ?string $altName = null, bool $coerced = false
	) {
		[ $doc, $body ] = self::createDoc( $domBuilder );
		$attributes = new TreeBuilder\ForeignAttributes(
			new Tokenizer\PlainAttributes( [ $name => $value ] ), $type ?? 'other'
		);
		$element = new TreeBuilder\Element(
			HTMLData::NS_HTML, $type ?? 'div', $attributes
		);
		$domBuilder->insertElement(
			TreeBuilder\TreeBuilder::UNDER, $body, $element, false, 12, 17
		);
		// verify using the dom
		$this->verifyAttribute(
			$doc, $name, $value, $altName, $coerced
		);
	}

	/** @dataProvider attributeProvider */
	public function testAttributesMergeAttributes(
		DOMBuilder $domBuilder, string $name, string $value,
		?string $type = null, ?string $altName = null, bool $coerced = false
	) {
		[ $doc, $body ] = self::createDoc( $domBuilder );
		$attributes = new TreeBuilder\ForeignAttributes(
			new Tokenizer\PlainAttributes( [ $name => $value ] ),
			$type ?? 'other'
		);
		$element = new TreeBuilder\Element(
			HTMLData::NS_HTML, $type ?? 'div',
			new Tokenizer\PlainAttributes( [] )
		);
		$domBuilder->insertElement(
			TreeBuilder\TreeBuilder::UNDER, $body, $element, false, 12, 17
		);
		$domBuilder->mergeAttributes( $element, $attributes, 0 );
		// verify using the dom
		$this->verifyAttribute(
			$doc, $name, $value, $altName, $coerced
		);
	}

	/** @dataProvider attributeProvider */
	public function testAttributesMergeAttributesNoReplace(
		DOMBuilder $domBuilder, string $name, string $value,
		?string $type = null, ?string $altName = null, bool $coerced = false
	) {
		[ $doc, $body ] = self::createDoc( $domBuilder );
		$attributes = new TreeBuilder\ForeignAttributes(
			new Tokenizer\PlainAttributes( [ $name => $value ] ),
			$type ?? 'other'
		);
		$element = new TreeBuilder\Element(
			HTMLData::NS_HTML, $type ?? 'div', $attributes
		);
		$domBuilder->insertElement(
			TreeBuilder\TreeBuilder::UNDER, $body, $element, false, 12, 17
		);
		$attributes2 = new TreeBuilder\ForeignAttributes(
			new Tokenizer\PlainAttributes( [ $name => 'new value' ] ),
			$type ?? 'other'
		);
		// This shouldn't have any effect, since the attribute was already
		// present.
		$domBuilder->mergeAttributes( $element, $attributes2, 0 );
		// verify using the dom
		$this->verifyAttribute(
			$doc, $name, $value, $altName, $coerced
		);
	}

	public static function attributeProvider() {
		// Use entities in the value to test for regressions in T324408
		$value = "foo &amp;amp; bar";
		foreach ( self::provideDOMBuilder() as $impl => $domBuilder ) {
			foreach ( [
				'simple', 'xmlns', 'xml:lang', 'xlink:title',
				'foo:bar', 'foo:bar:bat',
				'XmLnS',
			] as $name ) {
				yield "$impl $name" => [
					$domBuilder, $name, $value
				];
			}
			foreach ( [
				[ 'definitionurl', 'definitionURL' ],
			] as [ $name, $altName ] ) {
				yield "$impl math $name" => [
					$domBuilder, $name, $value, "math", $altName
				];
			}
			foreach ( [
				[ 'viewbox', 'viewBox' ],
			] as [ $name, $altName ] ) {
				yield "$impl svg $name" => [
					$domBuilder, $name, $value, "svg", $altName
				];
			}
			foreach ( [
				# T349310
				'data-ĳ',
				# The ':' gets coerced as well, alas.
				'foo:ĳ',
			] as $name ) {
				$altName = DOMUtils::coerceName( $name );
				yield "$impl $name" => [
					$domBuilder, $name, $value, null, $altName, true
				];
			}
		}
	}

	public static function provideDOMBuilder() {
		yield "DOMDocument(html ns)" => new DOMBuilder( [
			'domImplementationClass' => \DOMImplementation::class,
			'suppressHtmlNamespace' => false,
		] );
		yield "DOMDocument(no ns)" => new DOMBuilder( [
			'domImplementationClass' => \DOMImplementation::class,
			'suppressHtmlNamespace' => true,
		] );
		if ( class_exists( '\Dom\Document' ) ) {
			yield "Dom\Document(html ns)" => new DOMBuilder( [
				'domImplementationClass' => '\Dom\Implementation',
				'suppressHtmlNamespace' => false,
			] );
			yield "Dom\Document(no ns)" => new DOMBuilder( [
				'domImplementationClass' => '\Dom\Implementation',
				'suppressHtmlNamespace' => true,
			] );
		}
	}
}
