#!/usr/bin/env hhvm
<?php

if ( PHP_SAPI !== 'cli' ) {
	exit;
}

require __DIR__ . '/../vendor/autoload.php';

use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Serializer;

class NullHandler implements Tokenizer\TokenHandler {
	function startDocument() {}
	function endDocument( $pos ) {}
	function error( $text, $pos ) {}
	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {}
	function startTag( $name, Tokenizer\Attributes $attrs, $selfClose,
		$sourceStart, $sourceLength ) {}
	function endTag( $name, $sourceStart, $sourceLength ) {}
	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {}
	function comment( $text, $sourceStart, $sourceLength ) {}
}

class NullTreeHandler implements TreeBuilder\TreeHandler {
	function startDocument() {}
	function endDocument( $pos ) {}
	function characters( $parent, $refNode, $text, $start, $length, $sourceStart, $sourceLength ) {}
	function insertElement( $parent, $refNode, TreeBuilder\Element $element, $void,
		$sourceStart, $sourceLength ) {}
	function endTag( TreeBuilder\Element $element, $sourceStart, $sourceLength ) {}
	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {}
	function comment( $parent, $refNode, $text, $sourceStart, $sourceLength ) {}
	function error( $text, $pos ) {}
	function mergeAttributes( TreeBuilder\Element $element, Tokenizer\Attributes $attrs, $sourceStart ) {}
	function reparentNode( TreeBuilder\Element $element, TreeBuilder\Element $newParent, $sourceStart ) {}
	function removeNode( TreeBuilder\Element $element, $sourceStart ) {}
	function reparentChildren( TreeBuilder\Element $element, TreeBuilder\Element $newParent, $sourceStart ) {}
}

function reserialize( $text ) {
	$handler = new Tokenizer\TokenSerializer;
	$tokenizer = new Tokenizer\Tokenizer( $handler, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	print $handler->getOutput() . "\n";
	foreach ( $handler->getErrors() as $error ) {
		print "Error at {$error[1]}: {$error[0]}\n";
	}
}

function reseralizeScript( $text ) {
	$handler = new Tokenizer\TokenSerializer;
	$tokenizer = new Tokenizer\Tokenizer( $handler, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->switchState( Tokenizer\Tokenizer::STATE_SCRIPT_DATA, 'script' );
	$tokenizer->execute( Tokenizer\Tokenizer::STATE_SCRIPT_DATA );
	print $handler->getOutput() . "\n";
	foreach ( $handler->getErrors() as $error ) {
		print "Error at {$error[1]}: {$error[0]}\n";
	}
}

function traceDispatch( $text ) {
	TreeBuilder\Parser::parseDocument( $text, [ 'traceDispatch' => true ] );
}

function tidyBodyViaDOM( $text ) {
	$docText = "<!DOCTYPE html>\n<html><head></head><body>$text</body></html>";
	$doc = TreeBuilder\Parser::parseDocument( $docText, [] );
	$body = $doc->getElementsByTagName( 'body' )->item( 0 );
	foreach ( $body->childNodes as $node ) {
		print $doc->saveHTML( $node );
	}
	print "\n";
}

function tidyViaDOM( $text ) {
	$doc = TreeBuilder\Parser::parseDocument( $text, [
		'treeBuilder' => [
			'scopeCache' => true,
		]
	] );
	print $doc->saveHTML() . "\n";
}

function tidy( $text ) {
	$formatter = new Serializer\FastFormatter;
	$serializer = new Serializer\Serializer( $formatter );
	$treeBuilder = new TreeBuilder\TreeBuilder( $serializer, [] );
	$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
	$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	print $serializer->getResult() . "\n";
}

function benchmarkNull( $text ) {
	$time = -microtime( true );
	$handler = new NullHandler;
	$tokenizer = new Tokenizer\Tokenizer( $handler, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function benchmarkSerialize( $text ) {
	$time = -microtime( true );
	$handler = new Tokenizer\TokenSerializer;
	$tokenizer = new Tokenizer\Tokenizer( $handler, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function benchmarkTreeBuilder( $text ) {
	$time = -microtime( true );
	$handler = new NullTreeHandler;
	$treeBuilder = new TreeBuilder\TreeBuilder( $handler, [] );
	$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
	$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function benchmarkDOM( $text ) {
	$time = -microtime( true );
	$dom = TreeBuilder\Parser::parseDocument( $text, [
		'treeBuilder' => [
			'ignoreErrors' => true,
		],
		'tokenizer' => $GLOBALS['tokenizerOptions']
	] );
	$time += microtime( true );
	print "$time\n";
}

function benchmarkTidy( $text ) {
	$time = -microtime( true );
	$formatter = new Serializer\FastFormatter;
	$serializer = new Serializer\Serializer( $formatter );
	$treeBuilder = new TreeBuilder\TreeBuilder( $serializer, [] );
	$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
	$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $text, $GLOBALS['tokenizerOptions'] );
	$tokenizer->execute();
	$time += microtime( true );
	print "$time\n";
}

function generate( $text ) {
	$generator = Tokenizer\TokenGenerator::generate( $text, $GLOBALS['tokenizerOptions'] );
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
	$generator = Tokenizer\TokenGenerator::generate( $text, $GLOBALS['tokenizerOptions'] );
	foreach ( $generator as $token ) {
	}
	$time += microtime( true );
	print "$time\n";
}

$tokenizerOptions = [
	'ignoreNulls' => true,
	'ignoreCharRefs' => true,
	'ignoreErrors' => true,
	'skipPreprocess' => true,
];
$text = file_get_contents( '/tmp/Australia.html' );

while ( ( $__line = readline( "> " ) ) !== false ) {
	readline_add_history( $__line );
	$__val = eval( $__line . ";" );
}

