<?php

namespace Wikimedia\RemexHtml;

class TokenizerTest extends \PHPUnit_Framework_TestCase {
	public function provider() {
		$testDir = __DIR__ . '/../html5lib/tokenizer';
		$failedTests = 0;
		$tests = [];
		foreach ( glob( "$testDir/*.test" ) as $fileName ) {
			$lastPart = preg_replace( "/^.*\//s", '', $fileName );
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

	/** @dataProvider provider */
	public function testExecute( $state, $appropriateEndTag, $input, $expected ) {
		$handler = new TestTokenHandler();
		$tokenizer = new Tokenizer( $handler, $input, [] );
		$tokenizer->execute( $this->convertState( $state ), $appropriateEndTag );
		$this->assertEquals( $expected, $handler->getTokens() );
	}
}
