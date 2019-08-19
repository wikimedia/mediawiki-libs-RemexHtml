<?php

namespace RemexHtml\Tokenizer;

use RemexHtml\TreeBuilder\Dispatcher;
use RemexHtml\TreeBuilder\DispatchTracer;
use RemexHtml\TreeBuilder\NullTreeHandler;
use RemexHtml\TreeBuilder\TreeBuilder;

class RelayTokenHandlerTest extends \PHPUnit\Framework\TestCase {
	private function parse( $text ) {
		$null = new NullTreeHandler;
		$treeBuilder = new TreeBuilder( $null );
		$dispatcher = new Dispatcher( $treeBuilder );
		$trace = '';
		$dispatchTracer = new DispatchTracer( $text, $dispatcher,
			function ( $message ) use ( &$trace ) {
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
		$this->assertRegExp( '/startDocument/', $trace );
		$this->assertRegExp( '/doctype/', $trace );
		$this->assertRegExp( '/startTag/', $trace );
		$this->assertRegExp( '/characters/', $trace );
		$this->assertRegExp( '/comment/', $trace );
		$this->assertRegExp( '/endTag/', $trace );
		$this->assertRegExp( '/endDocument/', $trace );
		$this->assertRegExp( '/error/', $trace );
	}
}
