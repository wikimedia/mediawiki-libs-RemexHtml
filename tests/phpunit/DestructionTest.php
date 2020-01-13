<?php

namespace RemexHtml\Tests;

use RemexHtml\Serializer;
use RemexHtml\Tokenizer;
use RemexHtml\TreeBuilder;

class DestructTokenizer extends Tokenizer\Tokenizer {
	private $flag;

	public function __construct( Tokenizer\TokenHandler $listener, $text, $options, &$flag ) {
		parent::__construct( $listener, $text, $options );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

class DestructDispatcher extends TreeBuilder\Dispatcher {
	private $flag;

	public function __construct( TreeBuilder\TreeBuilder $builder, &$flag ) {
		parent::__construct( $builder );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

class DestructTreeBuilder extends TreeBuilder\TreeBuilder {
	private $flag;

	public function __construct( TreeBuilder\TreeHandler $handler, $options, &$flag ) {
		parent::__construct( $handler, $options );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

class DestructionTest extends \PHPUnit\Framework\TestCase {

	public function provider() {
		return [
			[ 'hello' ],
			[ '<a>' ],
			[ '<a><div><a>' ],
			[ '<table>Hello</table>' ],
			[ '<html><html>' ]
		];
	}

	/** @dataProvider provider */
	public function testDestruction( $input ) {
		$tokenizerGone = false;
		$dispatcherGone = false;
		$treeBuilderGone = false;

		$formatter = new Serializer\FastFormatter;
		$serializer = new Serializer\Serializer( $formatter );
		$treeBuilder = new DestructTreeBuilder( $serializer, [], $treeBuilderGone );
		$dispatcher = new DestructDispatcher( $treeBuilder, $dispatcherGone );
		$tokenizer = new DestructTokenizer( $dispatcher, $input, [], $tokenizerGone );
		$tokenizer->execute();

		$formatter = $serializer = $treeBuilder = $dispatcher = $tokenizer = null;

		$this->assertTrue( $tokenizerGone, 'Tokenizer gone' );
		$this->assertTrue( $dispatcherGone, 'Dispatcher gone' );
		$this->assertTrue( $treeBuilderGone, 'TreeBuilder gone' );
	}
}
