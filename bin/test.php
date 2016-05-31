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

function convertState( $state ) {
	switch ( $state ) {
	case 'data state':
		return Tokenizer::STATE_DATA;
	case 'RCDATA state':
		return Tokenizer::STATE_RCDATA;
	case 'RAWTEXT state':
		return Tokenizer::STATE_RAWTEXT;
	case 'PLAINTEXT state':
		return Tokenizer::STATE_PLAINTEXT;
	default:
		throw new \Exception( "Unrecognised state \"$state\"" );
	}
}

function testTokenizer() {
	$testDir = __DIR__ . '/../tests/html5lib/tokenizer';
	$failedTests = 0;
	foreach ( glob( "$testDir/*.test" ) as $fileName ) {
		$lastPart = preg_replace( "/^.*\//s", '', $fileName );
		print "Running tests from $lastPart\n";
		$testData = json_decode( file_get_contents( $fileName ), true );
		foreach ( $testData['tests'] as $test ) {
			$states = isset( $test['initialStates'] ) ? $test['initialStates']  : ['data state'];
			$input = $test['input'];
			$output = $test['output'];
			$appropriateEndTag = isset( $test['lastStartTag'] ) ? $test['lastStartTag'] : null;
			if ( !empty( $test['doubleEscaped'] ) ) {
				$input = json_decode( "\"$input\"" );
				$output = json_decode(
					str_replace( '\\\\', '\\', json_encode( $output ) ),
					true );
			}
			foreach ( $states as $state ) {
				$handler = new Wikimedia\RemexHtml\TestTokenHandler();
				$tokenizer = new Wikimedia\RemexHtml\Tokenizer( $handler, $input, [] );
				$tokenizer->execute( convertState( $state ), $appropriateEndTag );

				if ( $handler->getTokens() === $output ) {
					//print "OK: {$test['description']}\n";
				} else {
					print "FAILED: {$test['description']}\n";
					print "Expected: " . json_encode( $test['output'] ) . "\n";
					print "Got: " . json_encode( $handler->getTokens() ) . "\n";
					$failedTests++;
				}
			}
		}
		print "\n";
	}
	print "Failed $failedTests tests\n";
	return !$failedTests;
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
