<?php

namespace RemexHtml\FuzzTest;

use RemexHtml\Tokenizer;
use RemexHtml\TreeBuilder;
use RemexHtml\Serializer;

/**
 * Fuzz test implementation. Invoke with bin/fuzz.php
 *
 * Generate pseudorandom input, and run it in both Remex and Html5Depurate.
 * Flag any cases where the results differ.
 */
class FuzzTest {
	private $length;
	private $depurate;

	public function __construct( $length, $depurateUrl ) {
		$this->length = $length;
		$this->depurate = new Html5Depurate( $depurateUrl );
	}

	public function execute() {
		$tokenSalad = new TokenSalad( 10 );

		for ( $seed = 0; true; $seed++ ) {
			mt_srand( $seed );
			$text = $tokenSalad->next();
			// @codingStandardsIgnoreStart
			if ( @iconv( 'UTF-8', 'UTF-8', $text ) === false ) {
				// Skip invalid UTF-8 tests
				continue;
			}
			// @codingStandardsIgnoreEnd

			$formatter = new Serializer\DepurateFormatter( [
				'scriptingFlag' => false
			] );
			$serializer = new Serializer\Serializer( $formatter );
			$treeBuilder = new TreeBuilder\TreeBuilder( $serializer, [
				'scriptingFlag' => false
			] );
			$dispatcher = new TreeBuilder\Dispatcher( $treeBuilder );
			$tokenizer = new Tokenizer\Tokenizer( $dispatcher, $text, [
				'ignoreErrors' => true,
			] );

			try {
				$tokenizer->execute();
				$result = $serializer->getResult();
				$expected = $this->depurate->tidy( $text );
			} catch ( \Exception $e ) {
				print "Exception $seed\n$e\n";
			}

			if ( $result !== $expected ) {
				print "Error $seed\n" .
					"text = {$this->encode($text)}\n" .
					"result = {$this->encode($result)}\n" .
					"expected = {$this->encode($expected)}\n\n";
			} elseif ( $seed % 10000 === 0 && $seed !== 0 ) {
				print "Passed $seed\n";
			}
		}
	}

	private function encode( $text ) {
		return '"' .
			strtr( $text, [
				'\\' => '\\\\',
				'$' => '\\$',
				"\n" => '\\n',
				"\t" => '\\t',
				'"' => '\\"'
			] ) .
			'"';
	}
}
