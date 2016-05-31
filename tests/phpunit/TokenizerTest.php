<?php

namespace Wikimedia\RemexHtml;

class TokenizerTest extends \PHPUnit_Framework_TestCase {
	private static $skippedFiles = [
		'pendingSpecChanges.test'
	];

	public function provider() {
		$testDir = __DIR__ . '/../html5lib/tokenizer';
		$failedTests = 0;
		$tests = [];
		foreach ( glob( "$testDir/*.test" ) as $fileName ) {
			$lastPart = preg_replace( "/^.*\//s", '', $fileName );
			if ( in_array( $lastPart, self::$skippedFiles ) ) {
				continue;
			}
			$testData = json_decode( file_get_contents( $fileName ), true );
			if ( !isset( $testData['tests'] ) ) {
				continue;
			}
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
				$output = $this->normalizeErrors( $output );
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

	private function normalizeErrors( $tokens ) {
		$hasError = false;
		$output = [];
		$lastToken = false;
		foreach ( $tokens as $token ) {
			if ( $token === 'ParseError' ) {
				$hasError = true;
				continue;
			}
			if ( $lastToken[0] === 'Character' && $token[0] === 'Character' ) {
				$output[ count( $output ) - 1 ][1] .= $token[1];
			} else {
				$output[] = $token;
			}
			$lastToken = $token;
		}
		if ( $hasError ) {
			array_unshift( $output, 'ParseError' );
		}
		return $output;
	}


	/** @dataProvider provider */
	public function testExecute( $state, $appropriateEndTag, $input, $expected ) {
		$handler = new TestTokenHandler();
		$tokenizer = new Tokenizer( $handler, $input, [] );
		$tokenizer->execute( $this->convertState( $state ), $appropriateEndTag );
		$output = $this->normalizeErrors( $handler->getTokens() );
		$jsonOptions =  JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
		$this->assertEquals(
			json_encode( $expected, $jsonOptions ),
			json_encode( $output, $jsonOptions ) );
	}
}
