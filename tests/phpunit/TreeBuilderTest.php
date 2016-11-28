<?php

namespace Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder;
use Wikimedia\RemexHtml\Serializer;

class TreeBuilderTest extends \PHPUnit_Framework_TestCase {
	private static $testDirs = [
		'html5lib/tree-construction'
	];

	public function provider() {
		$testFiles = [];
		foreach ( self::$testDirs as $testDir ) {
			$testFiles = array_merge( $testFiles, glob( __DIR__ . "/../$testDir/*.dat" ) );
		}
		$args = [];
		foreach ( $testFiles as $fileName ) {
			$tests = $this->readFile( $fileName );
			foreach ( $tests as $test ) {
				if ( isset( $test['scripting'] ) ) {
					$args[] = [ $test ];
				} else {
					$test['scripting'] = false;
					$args[] = [ $test ];
					$test['scripting'] = true;
					$args[] = [ $test ];
				}
			}
		}
		return $args;
	}

	private function readFile( $fileName ) {
		$text = file_get_contents( $fileName );
		if ( $text === false ) {
			throw new \Exception( "Cannot read test file: $fileName" );
		}
		$baseName = "tree-construction/" . basename( $fileName );
		$pos = 0;
		$lineNum = 1;
		$tests = [];
		while ( true ) {
			$startLine = $lineNum;
			$section = $this->readSection( $text, $pos, $lineNum );
			if ( !$section ) {
				break;
			}
			if ( $section['name'] !== 'data' ) {
				throw new \Exception( "Invalid section at start of test: ${section['name']}" );
			}

			$test = [
				'data' => $section['value'],
				'file' => $baseName,
				'line' => $startLine
			];

			while ( true ) {
				$section = $this->readSection( $text, $pos, $lineNum );
				if ( !$section ) {
					break;
				}
				switch ( $section['name'] ) {
				case 'errors':
					$test['errors'] = explode( "\n", rtrim( $section['value'] ) );
					break;

				case 'document':
					$test['document'] = $section['value'];
					break;

				case 'document-fragment':
					$test['fragment'] = trim( $section['value'] );
					break;

				case 'script-on':
					$test['scripting'] = true;
					break;

				case 'script-off':
					$test['scripting'] = false;
					break;
				}
			}
			$tests[] = $test;
		}
		return $tests;
	}

	private function readSection( $text, &$pos, &$lineNum ) {
		if ( !preg_match( '/#([a-z-]*)\n/A', $text, $m, 0, $pos ) ) {
			return false;
		}

		$startPos = $pos;
		$name = $m[1];
		$valuePos = $pos + strlen( $m[0] );
		$endPos = strpos( $text, "\n\n", $valuePos );
		$hashPos = strpos( $text, "\n#", $valuePos );
		if ( $hashPos === false && $endPos === false ) {
			$value = substr( $text, $valuePos );
			$pos = strlen( $text );
		} elseif ( $hashPos === false || $endPos < $hashPos ) {
			$value = substr( $text, $valuePos, $endPos - $valuePos );
			$pos = $endPos + strlen( "\n\n" );
		} else {
			$value = substr( $text, $valuePos, $hashPos - $valuePos + 1 );
			$pos = $hashPos + 1;
		}
		$result = [
			'name' => $name,
			'value' => $value,
			'line' => $lineNum
		];
		$lineNum += substr_count( $text, "\n", $startPos, $pos - $startPos );
		return $result;
	}

	/** @dataProvider provider */
	public function testDefault( $params ) {
		$formatter = new Serializer\TestFormatter;
		$serializer = new Serializer\Serializer( $formatter );
		$treeBuilder = new TreeBuilder\TreeBuilder( $serializer, [
			'scriptingFlag' => $params['scripting']
		] );
		$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $params['data'], [] );
		$tokenizer->execute();
		$result = $serializer->getResult();

		$result = preg_replace( '/^/m', "| ", $result );
		$result = str_replace( '\n', "\n", $result );

		$this->assertEquals( $params['document'], $result, "{$params['file']}:{$params['line']}" );
	}
}
