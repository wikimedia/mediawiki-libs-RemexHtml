<?php

namespace Wikimedia\RemexHtml\Tests\Tokenizer;

use Wikimedia\RemexHtml\Tokenizer\RelayTokenHandler;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder\Dispatcher;
use Wikimedia\RemexHtml\TreeBuilder\DispatchTracer;
use Wikimedia\RemexHtml\TreeBuilder\NullTreeHandler;
use Wikimedia\RemexHtml\TreeBuilder\TreeBuilder;

/**
 * @covers \Wikimedia\RemexHtml\Tokenizer\RelayTokenHandler
 */
class RelayTokenHandlerTest extends \PHPUnit\Framework\TestCase {
	private function parse( $text ) {
		$null = new NullTreeHandler;
		$treeBuilder = new TreeBuilder( $null );
		$dispatcher = new Dispatcher( $treeBuilder );
		$trace = '';
		$dispatchTracer = new DispatchTracer( $text, $dispatcher,
			static function ( $message ) use ( &$trace ) {
				$trace .= $message . "\n";
			}
		);
		$relay = new RelayTokenHandler( $dispatchTracer );
		$tokenizer = new Tokenizer( $relay, $text );
		$tokenizer->execute();
		return $trace;
	}

	public function testEverything() {
		$trace = $this->parse( '<!doctype html><foo>x<!--y--></bar><' );

		$this->assertMatchesRegularExpression( '/startDocument/', $trace );
		$this->assertMatchesRegularExpression( '/doctype/', $trace );
		$this->assertMatchesRegularExpression( '/startTag/', $trace );
		$this->assertMatchesRegularExpression( '/characters/', $trace );
		$this->assertMatchesRegularExpression( '/comment/', $trace );
		$this->assertMatchesRegularExpression( '/endTag/', $trace );
		$this->assertMatchesRegularExpression( '/endDocument/', $trace );
		$this->assertMatchesRegularExpression( '/error/', $trace );
	}
}
