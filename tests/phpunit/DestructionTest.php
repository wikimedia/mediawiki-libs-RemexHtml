<?php

namespace Wikimedia\RemexHtml\Tests;

use Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder;

class DestructTokenizer extends Tokenizer\Tokenizer {
	/** @var bool */
	private $flag;

	public function __construct( Tokenizer\TokenHandler $listener, string $text, array $options, bool &$flag ) {
		parent::__construct( $listener, $text, $options );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

class DestructDispatcher extends TreeBuilder\Dispatcher {
	/** @var bool */
	private $flag;

	public function __construct( TreeBuilder\TreeBuilder $builder, bool &$flag ) {
		parent::__construct( $builder );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

class DestructTreeBuilder extends TreeBuilder\TreeBuilder {
	/** @var bool */
	private $flag;

	public function __construct( TreeBuilder\TreeHandler $handler, array $options, bool &$flag ) {
		parent::__construct( $handler, $options );
		$this->flag =& $flag;
	}

	public function __destruct() {
		$this->flag = true;
	}
}

/**
 * @coversNothing
 */
class DestructionTest extends \PHPUnit\Framework\TestCase {

	public function provider(): array {
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
