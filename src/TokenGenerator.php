<?php

namespace Wikimedia\RemexHtml;

class TokenGenerator {
	protected $handler;
	protected $tokenizer;

	protected function __construct( $text, $options ) {
		$this->handler = new TokenGeneratorHandler( $this );
		$this->tokenizer = new Tokenizer( $this->handler, $text, $options );
	}

	public static function generate( $text, $options ) {
		$tg = new self( $text, $options );
		$tg->tokenizer->beginStepping();
		while ( $tg->tokenizer->step() ) {
			foreach ( $tg->handler->tokens as $token ) {
				yield $token;
			}
			$tg->handler->tokens = [];
		}
		foreach ( $tg->handler->tokens as $token ) {
			yield $token;
		}
	}
}

