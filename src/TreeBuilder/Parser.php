<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;

class Parser {
	protected $domBuilder;
	protected $treeBuilder;
	protected $dispatcher;
	protected $tokenizer;

	private function __construct( $text, $options ) {
		$options += [
			'treeBuilder' => [],
			'tokenizer' => [],
			'domBuilder' => [],
			'traceDispatch' => false,
		];

		$this->domBuilder = new DOMBuilder( $options['domBuilder'] );
		$this->treeBuilder = new TreeBuilder( $this->domBuilder, $options['treeBuilder'] );
		$this->dispatcher = new Dispatcher( $this->treeBuilder );
		if ( $options['traceDispatch'] ) {
			$tokenHandler = new DispatchTracer( $text, $this->dispatcher,
				function ( $msg ) {
					print $msg;
				}
			);
		} else {
			$tokenHandler = $this->dispatcher;
		}
		$this->tokenizer = new Tokenizer( $tokenHandler, $text, $options['tokenizer'] );
		$this->treeBuilder->registerTokenizer( $this->tokenizer );
	}

	public static function parseDocument( $text, $options ) {
		$parser = new self( $text, $options );
		$parser->tokenizer->execute();
		return $parser->domBuilder->getDocument();
	}
}
