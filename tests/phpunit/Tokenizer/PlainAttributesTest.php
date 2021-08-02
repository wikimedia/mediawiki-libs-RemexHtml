<?php

namespace Wikimedia\RemexHtml\Tests\Tokenizer;

use PHPUnit\Framework\TestCase;
use Wikimedia\RemexHtml\Tokenizer\PlainAttributes;

class PlainAttributesTest extends TestCase {
	public function testMerge() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$this->assertSame( [ 'a' => '1' ], iterator_to_array( $a ) );
		$b = new PlainAttributes( [ 'b' => '2' ] );
		$this->assertSame( [ 'b' => '2' ], iterator_to_array( $b ) );
		$clone = clone $a;
		$a->merge( $b );
		$this->assertSame( [ 'a' => '1', 'b' => '2' ], iterator_to_array( $a ) );
		$this->assertSame( [ 'a' => '1' ], iterator_to_array( $clone ) );
	}

	public function testOffsetExists() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$this->assertTrue( isset( $a['a'] ) );
		$this->assertFalse( isset( $a['b'] ) );
	}

	public function testOffsetGet() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$this->assertSame( '1', $a['a'] );
	}

	public function testOffsetSet() {
		$a = new PlainAttributes( [] );
		$a->getObjects();
		$a['a'] = '1';
		$this->assertSame( '1', $a['a'] );
		$this->assertCount( 1, $a->getObjects() );
	}

	public function testOffsetUnset() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$a->getObjects();
		unset( $a['a'] );
		$this->assertSame( [], $a->getValues() );
		$this->assertSame( 0, $a->count() );
		$this->assertSame( [], $a->getObjects() );
	}

	public function testGetIterator() {
		$a = new PlainAttributes( [] );
		$a['a'] = '1';
		$this->assertInstanceOf( 'Iterator', $a->getIterator() );
		$this->assertSame( [ 'a' => '1' ], iterator_to_array( $a ) );
	}

	public function testGetValues() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$this->assertSame( [ 'a' => '1' ], $a->getValues() );
	}

	public function testGetObjects() {
		$a = new PlainAttributes( [ 'a' => '1' ] );
		$objs = $a->getObjects();
		$this->assertCount( 1, $objs );
		$attr = $objs['a'];
		$this->assertSame( 'a', $attr->qualifiedName );
		$this->assertSame( 'a', $attr->localName );
		$this->assertSame( '1', $attr->value );
		$this->assertNull( $attr->namespaceURI );
		$this->assertNull( $attr->prefix );
	}

	public function testCount() {
		$a = new PlainAttributes( [] );
		$a['a'] = '1';
		$a['b'] = '2';
		$this->assertSame( 2, $a->count() );
	}
}
