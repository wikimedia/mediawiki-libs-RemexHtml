<?php

namespace Wikimedia\RemexHtml;

class TokenGeneratorHandler implements TokenHandler {
	public $tokens = [];

	public function startDocument() {
		$this->tokens[] = ['type' => 'startDocument'];
	}

	public function endDocument() {
		$this->tokens[] = ['type' => 'endDocument'];
	}

	public function error( $text, $pos ) {
	}

	public function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$this->tokens[] = [
			'type' => 'text',
			'text' => $text,
			'start' => $start,
			'length' => $length,
			'sourceStart' => $sourceStart,
			'sourceLength' => $sourceLength ];
	}

	public function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		$this->tokens[] = [
			'type' => 'startTag',
			'name' => $name,
			'attrs' => $attrs,
			'selfClose' => $selfClose,
			'sourceStart' => $sourceStart,
			'sourceLength' => $sourceLength ];
	}

	public function endTag( $name, $sourceStart, $sourceLength ) {
		$this->tokens[] = [
			'type' => 'endTag',
			'name' => $name,
			'sourceStart' => $sourceStart,
			'sourceLength' => $sourceLength ];
	}

	public function doctype( $name, $public, $system, $quirks ) {
		$this->tokens[] = [
			'type' => 'doctype',
			'name' => $name,
			'public' => $public,
			'system' => $system,
			'quirks' => $quirks ];
	}

	public function comment( $text, $sourceStart, $sourceLength ) {
		$this->tokens[] = [
			'type' => 'comment',
			'text' => $text,
			'sourceStart' => $sourceStart,
			'sourceLength' => $sourceLength ];
	}
}
