<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer\TokenHandler;
use Wikimedia\RemexHtml\Tokenizer\Attributes;

class DispatchTracer implements TokenHandler {
	private $input;
	private $dispatcher;
	private $callback;

	function __construct( $input, Dispatcher $dispatcher, $callback ) {
		$this->input = $input;
		$this->dispatcher = $dispatcher;
		$this->callback = $callback;
	}

	private function trace( $msg ) {
		call_user_func( $this->callback, $msg );
	}

	private function wrap( $funcName, $sourceStart, $sourceLength, $args ) {
		$prevHandler = $this->getHandlerName();
		$msg = "$funcName $prevHandler\n";
		$msg .= '  ' . wordwrap( substr( $this->input, $sourceStart, $sourceLength ),
			75, "\n  " ) . "\n";
		$this->trace( $msg );
		call_user_func_array( [ $this->dispatcher, $funcName ], $args );
		$handler = $this->getHandlerName();
		if ( $prevHandler !== $handler ) {
			$this->trace( "$prevHandler -> $handler\n" );
		}
	}

	private function getHandlerName() {
		$name = get_class( $this->dispatcher->getHandler() );
		$slashPos = strrpos( $name, '\\' );
		if ( $slashPos === false ) {
			return $name;
		} else {
			return substr( $name, $slashPos + 1 );
		}
	}

	public function startDocument() {
		$this->wrap( __FUNCTION__, 0, 0, func_get_args() );
	}

	public function endDocument( $pos ) {
		$this->wrap( __FUNCTION__, $pos, 0, func_get_args() );
	}

	public function error( $text, $pos ) {
		$this->wrap( __FUNCTION__, $pos, 0, func_get_args() );
	}

	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, $sourceStart, $sourceLength, func_get_args() );
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, $sourceStart, $sourceLength, func_get_args() );
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, $sourceStart, $sourceLength, func_get_args() );
	}

	public function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, $sourceStart, $sourceLength, func_get_args() );
	}

	public function comment( $text, $sourceStart, $sourceLength ) {
		$this->wrap( __FUNCTION__, $sourceStart, $sourceLength, func_get_args() );
	}
}
