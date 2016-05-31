#!/usr/bin/env hhvm
<?php

require __DIR__ . '/../vendor/autoload.php';

use Wikimedia\RemexHtml\Tokenizer;

class NullHandler implements Wikimedia\RemexHtml\TokenHandler {
	function startDocument() {}
	function endDocument() {}
	function error( $text, $pos ) {}
	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {}
	function startTag( $name, Wikimedia\RemexHtml\Attributes $attrs, $selfClose,
		$sourceStart, $sourceLength ) {}
	function endTag( $name, $sourceStart, $sourceLength ) {}
	function doctype( $name, $public, $system, $quirks ) {}
	function comment( $text, $sourceStart, $sourceLength ) {}
}

function reserialize( $text ) {
	$handler = new Wikimedia\RemexHtml\TokenSerializer;
	$tokenizer = new Wikimedia\RemexHtml\Tokenizer( $handler, $text, $GLOBALS['options'] );
	$tokenizer->execute();
	print $handler->getOutput() . "\n";
	foreach ( $handler->getErrors() as $error ) {
		print "Error at {$error[1]}: {$error[0]}\n";
	}
}

function reseralizeScript( $text ) {
	$handler = new Wikimedia\RemexHtml\TokenSerializer;
	$tokenizer = new Wikimedia\RemexHtml\Tokenizer( $handler, $text, $GLOBALS['options'] );
	$tokenizer->switchState( Wikimedia\RemexHtml\Tokenizer::STATE_SCRIPT_DATA, 'script' );
	$tokenizer->execute( Wikimedia\RemexHtml\Tokenizer::STATE_SCRIPT_DATA );
	print $handler->getOutput() . "\n";
	foreach ( $handler->getErrors() as $error ) {
		print "Error at {$error[1]}: {$error[0]}\n";
	}
}

function benchmarkNull( $text ) {
	$time = -microtime( true );
	$handler = new NullHandler;
	$tokenizer = new Wikimedia\RemexHtml\Tokenizer( $handler, $text, $GLOBALS['options'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function benchmarkSerialize( $text ) {
	$time = -microtime( true );
	$handler = new Wikimedia\RemexHtml\TokenSerializer;
	$tokenizer = new Wikimedia\RemexHtml\Tokenizer( $handler, $text, $GLOBALS['options'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function generate( $text ) {
	$generator = Wikimedia\RemexHtml\TokenGenerator::generate( $text, $GLOBALS['options'] );
	foreach ( $generator as $token ) {
		if ( $token['type'] === 'text' ) {
			$token['text'] = substr( $token['text'], $token['start'], $token['length'] );
			unset( $token['start'] );
			unset( $token['length'] );
		}
		print_r( $token );
	}
}

function benchmarkGenerate( $text ) {
	$time = -microtime( true );
	$generator = Wikimedia\RemexHtml\TokenGenerator::generate( $text, $GLOBALS['options'] );
	foreach ( $generator as $token ) {
	}
	$time += microtime( true );
	print "$time\n";
}

$options = [];
/*$options = [
	'ignoreNulls' => true,
	'ignoreCharRefs' => true,
	'ignoreErrors' => true,
	'skipPreprocess' => true,
];*/
$text = file_get_contents( '/tmp/test.html' );

while ( ( $__line = readline( "> " ) ) !== false ) {
	readline_add_history( $__line );
	$__val = eval( $__line . ";" );
}	

/*
$tokenizer->execute();

 */
