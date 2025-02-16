<?php

namespace Wikimedia\RemexHtml\Tests\TreeBuilder;

use Wikimedia\RemexHtml\Tokenizer\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder\Dispatcher;
use Wikimedia\RemexHtml\TreeBuilder\NullTreeHandler;
use Wikimedia\RemexHtml\TreeBuilder\RelayTreeHandler;
use Wikimedia\RemexHtml\TreeBuilder\TreeBuilder;
use Wikimedia\RemexHtml\TreeBuilder\TreeMutationTracer;

/**
 * @covers \Wikimedia\RemexHtml\TreeBuilder\RelayTreeHandler
 */
class RelayTreeHandlerTest extends \PHPUnit\Framework\TestCase {
	private function parse( $text ) {
		$null = new NullTreeHandler;
		$trace = '';
		$tracer = new TreeMutationTracer( $null,
			static function ( $message ) use ( &$trace ) {
				$trace .= $message . "\n";
			}
		);
		$relay = new RelayTreeHandler( $tracer );
		$treeBuilder = new TreeBuilder( $relay );
		$dispatcher = new Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer( $dispatcher, $text );
		$tokenizer->execute();
		return $trace;
	}

	public function testEverythingExceptRemove() {
		$trace = $this->parse( '<!doctype html><body><body x><!--y--><b>x<p></b></p>' );
		$this->assertMatchesRegularExpression( '/startDocument/', $trace );
		$this->assertMatchesRegularExpression( '/doctype/', $trace );
		$this->assertMatchesRegularExpression( '/insert/', $trace );
		$this->assertMatchesRegularExpression( '/characters/', $trace );
		$this->assertMatchesRegularExpression( '/comment/', $trace );
		$this->assertMatchesRegularExpression( '/end/', $trace );
		$this->assertMatchesRegularExpression( '/endDocument/', $trace );
		$this->assertMatchesRegularExpression( '/error/', $trace );
		$this->assertMatchesRegularExpression( '/merge/', $trace );
		$this->assertMatchesRegularExpression( '/reparent/', $trace );
	}

	public function testRemove() {
		$trace = $this->parse( '<p><frameset>' );
		$this->assertMatchesRegularExpression( '/remove/', $trace );
	}

}
