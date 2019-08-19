<?php

namespace RemexHtml\Tokenizer;

class TokenizerTest extends \PHPUnit\Framework\TestCase {
	public static $testErrorCount = false;

	private static $skippedFiles = [
		// We don't implement draft changes
		'pendingSpecChanges.test',
		// Feeding invalid UTF-8 into the tokenizer causes an exception, which I
		// think is compliant and acceptable. The spec suggests that bare
		// surrogates could only appear in the input if a script stuffs them in,
		// since normal decoding will exclude them.
		'unicodeCharsProblematic.test'
	];

	private static $testDirs = [
		'html5lib/tokenizer'
	];

	public function provider() {
		$tests = [];
		$testFiles = [];
		foreach ( self::$testDirs as $testDir ) {
			$testFiles = array_merge( $testFiles, glob( __DIR__ . "/../../$testDir/*.test" ) );
		}
		foreach ( $testFiles as $fileName ) {
			$lastPart = preg_replace( "/^.*\//s", '', $fileName );
			if ( in_array( $lastPart, self::$skippedFiles ) ) {
				continue;
			}
			$testData = json_decode( file_get_contents( $fileName ), true );
			if ( !isset( $testData['tests'] ) ) {
				continue;
			}
			foreach ( $testData['tests'] as $test ) {
				$states = isset( $test['initialStates'] ) ? $test['initialStates'] : [ 'data state' ];
				$input = $test['input'];
				$output = $test['output'];
				$appropriateEndTag = isset( $test['lastStartTag'] ) ? $test['lastStartTag'] : null;
				if ( !empty( $test['doubleEscaped'] ) ) {
					$input = $this->unescape( $input );
					$output = $this->unescape( $output );
				}
				foreach ( $states as $state ) {
					if ( count( $states ) > 1 ) {
						$description = "$lastPart: {$test['description']} ({$state})";
					} else {
						$description = "$lastPart: {$test['description']}";
					}
					$tests[$description] = [
						$state,
						$appropriateEndTag,
						$input,
						$output
					];
				}
			}
		}
		return $tests;
	}

	/**
	 * Unescape "double-escaped" JSON strings -- in practise this means decoding
	 * unusual unicode characters such as bare surrogates. Just running it through
	 * json_decode() again appears to work on HHVM, but on PHP invalid characters
	 * are replaced with U+FFFD.
	 */
	private function unescape( $value ) {
		if ( is_array( $value ) ) {
			return array_map( [ $this, 'unescape' ], $value );
		} elseif ( is_string( $value ) ) {
			return preg_replace_callback( '/\\\\u([0-9a-fA-F]{4})/',
				function ( $m ) {
					return \UtfNormal\Utils::codepointToUtf8( intval( $m[1], 16 ) );
				},
				$value );
		} else {
			return $value;
		}
	}

	private function convertState( $state ) {
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

	private function normalizeErrors( $tokens, $remove = false ) {
		$errorCount = 0;
		$output = [];
		$lastToken = false;
		foreach ( $tokens as $token ) {
			if ( $token === 'ParseError' ) {
				$errorCount++;
				continue;
			}
			if ( $lastToken[0] === 'Character' && $token[0] === 'Character' ) {
				$output[ count( $output ) - 1 ][1] .= $token[1];
			} else {
				$output[] = $token;
			}
			$lastToken = $token;
		}
		if ( $errorCount && !$remove ) {
			if ( self::$testErrorCount ) {
				array_splice( $output, 0, 0, array_fill( 0, $errorCount, 'ParseError' ) );
			} else {
				array_unshift( $output, 'ParseError' );
			}
		}
		return $output;
	}

	/** @dataProvider provider */
	public function testDefault( $state, $appropriateEndTag, $input, $expected ) {
		$handler = new TestTokenHandler();
		$tokenizer = new Tokenizer( $handler, $input, [] );
		$tokenizer->execute( [
			'state' => $this->convertState( $state ),
			'appropriateEndTag' => $appropriateEndTag ] );
		$output = $this->normalizeErrors( $handler->getTokens() );
		$expected = $this->normalizeErrors( $expected );
		$jsonOptions = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
		$this->assertEquals(
			json_encode( $expected, $jsonOptions ),
			json_encode( $output, $jsonOptions ) );
	}

	/** @dataProvider provider */
	public function testIgnoreErrors( $state, $appropriateEndTag, $input, $expected ) {
		$handler = new TestTokenHandler();
		$tokenizer = new Tokenizer( $handler, $input, [ 'ignoreErrors' => true ] );
		$tokenizer->execute( [
			'state' => $this->convertState( $state ),
			'appropriateEndTag' => $appropriateEndTag ] );
		$output = $this->normalizeErrors( $handler->getTokens(), true );
		$expected = $this->normalizeErrors( $expected, true );
		$jsonOptions = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
		$this->assertEquals(
			json_encode( $expected, $jsonOptions ),
			json_encode( $output, $jsonOptions ) );
	}

	public function provideIgnoreErrors() {
		return [
			'ignoreErrors=false' => [ false ],
			'ignoreErrors=true' => [ true ],
		];
	}

	/** @dataProvider provideIgnoreErrors */
	public function testDoubleDecode( $ignoreErrors ) {
		$handler = new TestTokenHandler();
		$tokenizer = new Tokenizer( $handler, '&amp;amp;', [ 'ignoreErrors' => $ignoreErrors ] );
		$tokenizer->execute( [
			'state' => Tokenizer::STATE_DATA
		] );
		$output = $this->normalizeErrors( $handler->getTokens() );
		$output = json_encode( $output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		$this->assertEquals( '[["Character","&amp;"]]', $output );
	}
}
