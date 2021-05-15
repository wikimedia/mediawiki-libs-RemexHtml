<?php

namespace RemexHtml\TreeBuilder;

use RemexHtml\Tokenizer\Tokenizer;

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
		// PHPUnit 8.x compatibility (for PHP 7.2 support)
		if ( !method_exists( $this, 'assertMatchesRegularExpression' ) ) {
			$this->assertRegExp( '/startDocument/', $trace );
			$this->assertRegExp( '/doctype/', $trace );
			$this->assertRegExp( '/insert/', $trace );
			$this->assertRegExp( '/characters/', $trace );
			$this->assertRegExp( '/comment/', $trace );
			$this->assertRegExp( '/end/', $trace );
			$this->assertRegExp( '/endDocument/', $trace );
			$this->assertRegExp( '/error/', $trace );
			$this->assertRegExp( '/merge/', $trace );
			$this->assertRegExp( '/reparent/', $trace );
		} else {
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
	}

	public function testRemove() {
		$trace = $this->parse( '<p><frameset>' );
		// PHPUnit 8.x compatibility (for PHP 7.2 support)
		if ( !method_exists( $this, 'assertMatchesRegularExpression' ) ) {
			$this->assertRegExp( '/remove/', $trace );
		} else {
			$this->assertMatchesRegularExpression( '/remove/', $trace );
		}
	}

}
