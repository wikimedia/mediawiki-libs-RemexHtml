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
			'traceTreeMutation' => false,
		];

		$this->domBuilder = new DOMBuilder( $options['domBuilder'] );
		if ( $options['traceTreeMutation'] ) {
			$treeHandler = new TreeMutationTracer( $this->domBuilder,
				function ( $msg ) {
					print "$msg\n";
				}
			);
		} else {
			$treeHandler = $this->domBuilder;
		}
		$this->treeBuilder = new TreeBuilder( $treeHandler, $options['treeBuilder'] );
		$this->dispatcher = new Dispatcher( $this->treeBuilder );
		if ( $options['traceDispatch'] ) {
			$tokenHandler = new DispatchTracer( $text, $this->dispatcher,
				function ( $msg ) {
					print "$msg\n";
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
