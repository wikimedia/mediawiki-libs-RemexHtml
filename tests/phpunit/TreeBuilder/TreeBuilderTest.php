<?php

namespace Wikimedia\RemexHtml\Tests\TreeBuilder;

use InvalidArgumentException;
use Wikimedia\RemexHtml\DOM;
use Wikimedia\RemexHtml\HTMLData;
use Wikimedia\RemexHtml\Serializer;
use Wikimedia\RemexHtml\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder\Dispatcher;
use Wikimedia\RemexHtml\TreeBuilder\TreeBuilder;

/**
 * @covers \Wikimedia\RemexHtml\TreeBuilder\TreeBuilder
 */
class TreeBuilderTest extends \PHPUnit\Framework\TestCase {
	public const TEST_ERROR_COUNTS = false;

	private const TEST_DIRS = [
		'html5lib/tree-construction',
		'local/tree-construction',
	];

	private const FILE_BLACKLIST = [
		// Refers to a newer version of the HTML spec
		'tree-construction/menuitem-element.dat',
	];

	private const TEST_BLACKLIST = [
	];

	private const DOM_TEST_BLACKLIST = [
		// Invalid doctype
		'tree-construction/doctype01.dat:32',
		'tree-construction/doctype01.dat:45',
		'tree-construction/doctype01.dat:313:dom84',
		'tree-construction/tests2.dat:756:dom84',
		'tree-construction/tests6.dat:48',
	];

	/** @var string[] */
	private $errors;

	public static function serializerProvider() {
		return self::provider( 'serializer' );
	}

	public static function domProvider() {
		return self::provider( 'dom' );
	}

	public static function dom84Provider() {
		return self::provider( 'dom84' );
	}

	private static function provider( $type ) {
		$testFiles = [];
		foreach ( self::TEST_DIRS as $testDir ) {
			$testFiles = array_merge( $testFiles, glob( __DIR__ . "/../../$testDir/*.dat" ) );
		}
		$args = [];
		foreach ( $testFiles as $fileName ) {
			if ( in_array( 'tree-construction/' . basename( $fileName ), self::FILE_BLACKLIST ) ) {
				continue;
			}
			$tests = self::readFile( $fileName, $type );

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

	private static function readFile( $fileName, $type ) {
		$text = file_get_contents( $fileName );
		if ( $text === false ) {
			throw new InvalidArgumentException( "Cannot read test file: $fileName" );
		}
		$baseName = "tree-construction/" . basename( $fileName );
		$pos = 0;
		$lineNum = 1;
		$tests = [];
		while ( true ) {
			$startLine = $lineNum;
			$section = self::readSection( $text, $pos, $lineNum );
			if ( !$section ) {
				break;
			}
			if ( $section['name'] !== 'data' ) {
				throw new InvalidArgumentException( "Invalid section at start of test: {$section['name']}" );
			}

			$test = [
				'data' => $section['value'],
				'file' => $baseName,
				'line' => $startLine
			];

			do {
				$section = self::readSection( $text, $pos, $lineNum );
				if ( !$section ) {
					break;
				}
				switch ( $section['name'] ) {
					case 'errors':
						if ( $section['value'] === '' ) {
							$test['errors'] = [];
						} else {
							$test['errors'] = explode( "\n", $section['value'] );
						}
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

			// @phan-suppress-next-line PhanSuspiciousWeakTypeComparisonInLoop
			if ( in_array( "$baseName:$startLine", self::TEST_BLACKLIST ) ) {
				continue;
			}
			if ( str_starts_with( $type, 'dom' ) && (
				 in_array( "$baseName:$startLine", self::DOM_TEST_BLACKLIST )
				 ||
				 in_array( "$baseName:$startLine:$type", self::DOM_TEST_BLACKLIST )
			) ) {
				continue;
			}

			$tests[] = $test;
		}
		return $tests;
	}

	private static function readSection( $text, &$pos, &$lineNum ) {
		if ( !preg_match( '/#([a-z-]*)\n/A', $text, $m, 0, $pos ) ) {
			return false;
		}

		$sectionLineNum = $lineNum++;
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

	public function errorCallback( $msg, $pos ) {
		$this->errors[] = "[$pos] $msg\n";
	}

	/** @dataProvider serializerProvider */
	public function testSerializer( $params ) {
		$formatter = new Serializer\TestFormatter;
		$serializer = new Serializer\Serializer( $formatter, [ $this, 'errorCallback' ] );
		$this->runWithSerializer( $serializer, $params, true );
	}

	/** @dataProvider domProvider */
	public function testDOMSerializer( $params ) {
		$formatter = new Serializer\TestFormatter;
		$builder = new DOM\DOMBuilder( [
			'errorCallback' => [ $this, 'errorCallback' ]
		] );
		$serializer = new DOM\DOMSerializer( $builder, $formatter );
		$this->runWithSerializer( $serializer, $params );
	}

	/** @dataProvider dom84Provider */
	public function testDOMSerializer84( $params ) {
		if ( !class_exists( '\Dom\Document' ) ) {
			$this->markTestSkipped( 'requires PHP >= 8.4' );
		}
		$formatter = new Serializer\TestFormatter;
		$builder = new DOM\DOMBuilder( [
			'domImplementationClass' => '\Dom\Implementation',
			'errorCallback' => [ $this, 'errorCallback' ]
		] );
		$serializer = new DOM\DOMSerializer( $builder, $formatter );
		$this->runWithSerializer( $serializer, $params );
	}

	private function runWithSerializer(
		Serializer\AbstractSerializer $serializer,
		$params,
		$normalizeTextNodes = false
	) {
		if ( !isset( $params['document'] ) ) {
			throw new InvalidArgumentException( "Test lacks #document: {$params['file']}:{$params['line']}" );
		}
		$treeBuilder = new TreeBuilder( $serializer, [
			'scriptingFlag' => $params['scripting']
		] );
		$dispatcher = new Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $params['data'], [] );

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

		$this->errors = [];
		$tokenizer->execute( $tokenizerOptions );
		$result = $serializer->getResult();

		// Normalize adjacent text nodes
		if ( $normalizeTextNodes ) {
			do {
				$prevResult = $result;
				$result = preg_replace( '/^([ ]*)"([^"]*+)"\n\1"([^"]*+)"\n/m', "\\1\"\\2\\3\"\n", $result );
			} while ( $prevResult !== $result );
		}

		// Format appropriately
		$result = preg_replace( '/^/m', "| ", $result );
		$result = str_replace( '<EOL>', "\n", $result );

		// Normalize terminating line break
		$result = rtrim( $result, "\n" );
		$expected = rtrim( $params['document'], "\n" );

		$this->assertEquals( $expected, $result, "{$params['file']}:{$params['line']}" );

		// @phan-suppress-next-line PhanImpossibleCondition
		if ( self::TEST_ERROR_COUNTS ) {
			$this->assertSameSize(
				$params['errors'],
				$this->errors,
				"{$params['file']}:{$params['line']} error count" );
		}
	}
}
