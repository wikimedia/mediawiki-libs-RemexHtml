<?php

namespace RemexHtml\TreeBuilder;
use RemexHtml\HTMLData;
use RemexHtml\Tokenizer;
use RemexHtml\TreeBuilder;
use RemexHtml\Serializer;

class TreeBuilderTest extends \PHPUnit_Framework_TestCase {
	private static $testDirs = [
		'html5lib/tree-construction'
	];

	private static $fileBlacklist = [
		// Refers to a newer version of the HTML spec
		'tree-construction/menuitem-element.dat',
		'tree-construction/pending-spec-changes.dat',
	];

	private static $testBlacklist = [
		// Refers to a newer version of the HTML spec
		'tree-construction/main-element.dat:30',
		'tree-construction/tests11.dat:137',
		'tree-construction/ruby.dat:186',
		'tree-construction/template.dat:1102',
	];

	public function provider() {
		$testFiles = [];
		foreach ( self::$testDirs as $testDir ) {
			$testFiles = array_merge( $testFiles, glob( __DIR__ . "/../$testDir/*.dat" ) );
		}
		$args = [];
		foreach ( $testFiles as $fileName ) {
			if ( in_array( 'tree-construction/' . basename( $fileName ), self::$fileBlacklist ) ) {
				continue;
			}
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

			do {
				$section = $this->readSection( $text, $pos, $lineNum );
				if ( !$section ) {
					break;
				}
				switch ( $section['name'] ) {
				case 'errors':
					$test['errors'] = explode( "\n", rtrim( $section['value'], "\n" ) );
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
			} while ( !$section['end'] );
			
			if ( !in_array( "$baseName:$startLine", self::$testBlacklist ) ) {
				$tests[] = $test;
			}
		}
		return $tests;
	}

	private function readSection( $text, &$pos, &$lineNum ) {
		if ( !preg_match( '/#([a-z-]*)\n/A', $text, $m, 0, $pos ) ) {
			return false;
		}

		$sectionLineNum = $lineNum++;
		$startPos = $pos;
		$name = $m[1];
		$valuePos = $pos + strlen( $m[0] );
		$pos = $valuePos;
		$value = '';
		$isEnd = false;

		while ( !$isEnd && $pos < strlen( $text ) ) {
			$lineStart = $pos;
			$lineLength = strcspn( $text, "\n", $pos );
			$pos += $lineLength;
			if ( $pos >= strlen( $text ) ) {
				$isEnd = true;
			} elseif ( $text[$pos] === "\n" ) {
				$pos++;
				$lineNum++;
			}

			$line = substr( $text, $lineStart, $lineLength );
			if ( $name === 'data' ) {
				// Double line breaks can appear in #data
			} elseif ( $name === 'document' && preg_match( '/\s*"/A', $text, $m, 0, $pos ) ) {
				// Line breaks in #document can be escaped with quotes
			} elseif ( $line === '' ) {
				$isEnd = true;
				break;
			}

			if ( preg_match( '/^#([a-z-]*)$/', $line ) ) {
				$pos = $lineStart;
				$lineNum--;
				break;
			}
			if ( $value !== '' ) {
				$value .= "\n";
			}
			$value .= $line;
		}

		$result = [
			'name' => $name,
			'value' => $value,
			'line' => $sectionLineNum,
			'end' => $isEnd,
		];
		return $result;
	}

	/** @dataProvider provider */
	public function testDefault( $params ) {
		if ( !isset( $params['document'] ) ) {
			throw new \Exception( "Test lacks #document: {$params['file']}:{$params['line']}" );
		}
		$formatter = new Serializer\TestFormatter;
		$serializer = new Serializer\Serializer( $formatter );
		$treeBuilder = new TreeBuilder\TreeBuilder( $serializer, [
			'scriptingFlag' => $params['scripting']
		] );
		$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $params['data'], [] );
		$treeBuilder->registerTokenizer( $tokenizer );

		$tokenizerOptions = [];

		if ( isset( $params['fragment'] ) ) {
			$fragment = explode( ' ', $params['fragment'] );
			if ( count( $fragment ) > 1 ) {
				if ( $fragment[0] === 'svg' ) {
					$ns = HTMLData::NS_SVG;
				} elseif ( $fragment[0] === 'math' ) {
					$ns = HTMLData::NS_MATHML;
				} else {
					$ns = HTMLData::NS_HTML;
				}
				$name = $fragment[1];
			} else {
				$ns = HTMLData::NS_HTML;
				$name = $fragment[0];
			}
			$tokenizerOptions['fragmentNamespace'] = $ns;
			$tokenizerOptions['fragmentName'] = $name;
		}

		$tokenizer->execute( $tokenizerOptions );
		$result = $serializer->getResult();

		// Normalize adjacent text nodes
		do {
			$prevResult = $result;
			$result = preg_replace( '/^([ ]*)"([^"]*+)"\n\1"([^"]*+)"\n/m', "\\1\"\\2\\3\"\n", $result );
		} while ( $prevResult !== $result );

		// Format appropriately
		$result = preg_replace( '/^/m', "| ", $result );
		$result = str_replace( '<EOL>', "\n", $result );

		// Normalize terminating line break
		$result = rtrim( $result, "\n" );
		$expected = rtrim( $params['document'], "\n" );

		$this->assertEquals( $expected, $result, "{$params['file']}:{$params['line']}" );
	}
}
