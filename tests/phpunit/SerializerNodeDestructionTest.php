<?php

namespace Wikimedia\RemexHtml\Tests;

use Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder;

class SerializerDestructAttacher implements TreeBuilder\TreeHandler {
	private Serializer\Serializer $serializer;
	/** @var int */
	private $count;

	public function __construct( Serializer\Serializer $serializer, int &$count ) {
		$this->serializer = $serializer;
		$this->count =& $count;
	}

	private function wrap( string $name, array $args ) {
		$this->serializer->$name( ...$args );
	}

	public function startDocument( $fragmentNamespace, $fragmentName ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function endDocument( $pos ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function characters( $preposition, $ref, $text, $start, $length,
		$sourceStart, $sourceLength
	) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function insertElement( $preposition, $ref, TreeBuilder\Element $element, $void,
		$sourceStart, $sourceLength
	) {
		$this->wrap( __FUNCTION__, func_get_args() );
		if ( !$element->userData->snData ) {
			$element->userData->snData = new DestructNode( $this->count );
		}
	}

	public function endTag( TreeBuilder\Element $element, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function comment( $preposition, $ref, $text, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function error( $text, $pos ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function mergeAttributes( TreeBuilder\Element $element, Tokenizer\Attributes $attrs,
		$sourceStart
	) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function removeNode( TreeBuilder\Element $element, $sourceStart ) {
		$this->wrap( __FUNCTION__, func_get_args() );
	}

	public function reparentChildren( TreeBuilder\Element $element, TreeBuilder\Element $newParent,
		$sourceStart
	) {
		$this->wrap( __FUNCTION__, func_get_args() );
		if ( !$newParent->userData->snData ) {
			$newParent->userData->snData = new DestructNode( $this->count );
		}
	}
}

class DestructNode {
	/** @var int */
	private $count;

	public function __construct( int &$count ) {
		$this->count =& $count;
	}

	public function __destruct() {
		$this->count++;
	}
}

/**
 * @coversNothing
 */
class SerializerNodeDestructionTest extends \PHPUnit\Framework\TestCase {
	public function testDestruction() {
		$input = '<div></div><div></div><div></div><div></div>';

		$count = 0;
		$formatter = new Serializer\FastFormatter;
		$serializer = new Serializer\Serializer( $formatter );
		$attacher = new SerializerDestructAttacher( $serializer, $count );
		$treeBuilder = new TreeBuilder\TreeBuilder( $attacher, [] );
		$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $input, [] );
		$tokenizer->beginStepping();

		$continue = true;
		for ( $i = 0; $i < 4 && $count == 0 && $continue; $i++ ) {
			$continue = $tokenizer->step();
		}
		$this->assertSame( 1, $count );
		while ( $tokenizer->step() ) {
		}
		$this->assertEquals( 7, $count );
	}
}
