<?php

namespace RemexHtml\Tokenizer;

use PHPUnit\Framework\TestCase;

class LazyAttributesTest extends TestCase {
	private function create( $idx ) {
		$data = new \stdClass;
		return new LazyAttributes( $data, static function () use ( $idx ) {
			return [ "k$idx" => "v$idx" ];
		} );
	}

	public function testMerge() {
		$a = $this->create( 1 );
		$b = $this->create( 2 );
		$a->merge( $b );
		$this->assertSame( [ 'k1' => 'v1', 'k2' => 'v2' ], iterator_to_array( $a ) );
	}

	public function testOffsetExists() {
		$a = $this->create( 1 );
		$this->assertTrue( isset( $a['k1'] ) );
		$this->assertFalse( isset( $a['k2'] ) );
	}

	public function testOffsetGet() {
		$a = $this->create( 1 );
		$this->assertSame( 'v1', $a['k1'] );
	}

	public function testOffsetSet() {
		$a = $this->create( 1 );
		$a->getObjects();
		$a['a'] = '1';
		$this->assertSame( '1', $a['a'] );
		$this->assertSame( 'v1', $a['k1'] );
		$this->assertCount( 2, $a->getObjects() );
	}

	public function testOffsetUnset() {
		$a = $this->create( 1 );
		$a->getObjects();
		unset( $a['k1'] );
		$this->assertSame( [], $a->getValues() );
		$this->assertSame( 0, $a->count() );
		$this->assertSame( [], $a->getObjects() );
	}

	public function testGetIterator() {
		$a = $this->create( 1 );
		$this->assertInstanceOf( 'Iterator', $a->getIterator() );
		$this->assertSame( [ 'k1' => 'v1' ], iterator_to_array( $a ) );
	}

	public function testGetValues() {
		$a = $this->create( 1 );
		$this->assertSame( [ 'k1' => 'v1' ], $a->getValues() );
	}

	public function testGetObjects() {
		$a = $this->create( 1 );
		$objs = $a->getObjects();
		$this->assertCount( 1, $objs );
		$attr = $objs['k1'];
		$this->assertSame( 'k1', $attr->qualifiedName );
		$this->assertSame( 'k1', $attr->localName );
		$this->assertSame( 'v1', $attr->value );
		$this->assertNull( $attr->namespaceURI );
		$this->assertNull( $attr->prefix );
	}

	public function testCount() {
		$a = $this->create( 1 );
		$a['a'] = '1';
		$a['b'] = '2';
		$this->assertSame( 3, $a->count() );
	}

}
