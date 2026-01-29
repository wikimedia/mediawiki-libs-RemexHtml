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
				// For non-coerced attributes, only the alternative name should
				// be set.
				$this->assertFalse( $domElement->hasAttribute( $name ) );
				$name = $altName;
			}
		}
		$this->assertTrue( $domElement->hasAttribute( $name ), "$name is not present" );
		$this->assertSame( $value, $domElement->getAttribute( $name ), "$name has incorrect value" );
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
		$namespace = match ( $type ) {
			'math' => HTMLData::NS_MATHML,
			'svg' => HTMLData::NS_SVG,
			default => HTMLData::NS_HTML,
		};
		$element = new TreeBuilder\Element(
			$namespace, $type ?? 'div', $attributes
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
		$namespace = match ( $type ) {
			'math' => HTMLData::NS_MATHML,
			'svg' => HTMLData::NS_SVG,
			default => HTMLData::NS_HTML,
		};
		$element = new TreeBuilder\Element(
			$namespace, $type ?? 'div',
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
		$namespace = match ( $type ) {
			'math' => HTMLData::NS_MATHML,
			'svg' => HTMLData::NS_SVG,
			default => HTMLData::NS_HTML,
		};
		$element = new TreeBuilder\Element(
			$namespace, $type ?? 'div', $attributes
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

	/** @dataProvider providePrefixedElements */
	public function testPrefixedElements(
		DOMBuilder $domBuilder, bool $suppressHtmlNamespace,
		string $name, string $expectedNS
	) {
		[ $doc, $body ] = self::createDoc( $domBuilder );
		$element = new TreeBuilder\Element(
			$expectedNS, $name,
			new TreeBuilder\ForeignAttributes(
				new Tokenizer\PlainAttributes( [] ),
				'other'
			)
		);
		$domBuilder->insertElement(
			TreeBuilder\TreeBuilder::UNDER, $body, $element, false, 12, 17
		);
		// gently lie to phan about the type of $doc and $domElement
		'@phan-var \DOMDocument $doc';
		$domElement = $doc->documentElement->firstChild->firstChild;
		'@phan-var \DOMElement $domElement';
		$this->assertNotNull( $domElement );
		// According to HTML spec, this should have localName='mw:editsection',
		// prefix=null, and namespaceURI either null (when
		// 'suppressHtmlNamespace' or equals to HTMLData::NS_HTML)
		$this->assertEquals( $name, $domElement->localName );
		$this->assertNull( $domElement->prefix ?: null );
		// NOTE: This is an unresolvable bug with \DOMImplementation::class
		// and `suppressHtmlNamespace=false`: there's no way to create the
		// element with the proper namespace.  It is recommended to always
		// set `suppressHtmlNamespace=true` when using \DOMImplementation.
		if ( $domElement instanceof \DOMElement && !$suppressHtmlNamespace ) {
			return;
		}
		$this->assertEquals(
			$suppressHtmlNamespace && $expectedNS === HTMLData::NS_HTML ?
				null : $expectedNS,
			$domElement->namespaceURI ?: null
		);
	}

	public static function providePrefixedElements() {
		foreach ( self::provideDOMBuilder() as $impl => [ $domBuilder, $suppressHtmlNamespace ] ) {
			foreach ( [
				[ 'div', HTMLData::NS_HTML ],
				[ 'mw:section', HTMLData::NS_HTML ],
				[ 'math', HTMLData::NS_MATHML ],
			] as [ $elementName, $expectedNS ] ) {
				yield "$impl <$elementName>" => [ $domBuilder, $suppressHtmlNamespace, $elementName, $expectedNS ];
			}
		}
	}

	public static function attributeProvider() {
		// Use entities in the value to test for regressions in T324408
		$value = "foo &amp;amp; bar";
		foreach ( self::provideDOMBuilder() as $impl => [ $domBuilder, $ignore ] ) {
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
		foreach ( [ false, true ] as $suppressHtmlNamespace ) {
			$desc = $suppressHtmlNamespace ? '(no ns)' : '(html ns)';
			yield "DOMDocument$desc" => [ new DOMBuilder( [
				'domImplementationClass' => \DOMImplementation::class,
				'domExceptionClass' => \DOMException::class,
				'suppressHtmlNamespace' => $suppressHtmlNamespace,
			] ), $suppressHtmlNamespace ];
			if ( class_exists( '\Dom\Document' ) ) {
				yield "Dom\Document$desc" => [ new DOMBuilder( [
					'domImplementationClass' => '\Dom\Implementation',
					'domExceptionClass' => '\Dom\Exception',
					'suppressHtmlNamespace' => $suppressHtmlNamespace,
				] ), $suppressHtmlNamespace ];
			}
		}
	}
}
