<?php

namespace Wikimedia\RemexHtml\Tools;

use Wikimedia\RemexHtml\DOM\DOMBuilder;
use Wikimedia\RemexHtml\Tokenizer\Tokenizer;
use Wikimedia\RemexHtml\TreeBuilder\Dispatcher;
use Wikimedia\RemexHtml\TreeBuilder\TreeBuilder;

/**
 * Benchmark HTML parsing to DOM using various DOM implementations.
 */
class Benchmark {
	public const ITERATIONS = 25;
	public const ROUNDING = 4;

	/** The html string to be used for the benchmarks. */
	private string $html;

	private function __construct( string $html ) {
		$this->html = $html;
	}

	/**
	 * Evaluate a set of DOMBuilder opts for the presence of various bugs
	 * in the output when those options are used.
	 */
	private static function evalOpts( array $opts ): array {
		$doc = self::parse( '<!DOCTYPE html><body id=body>foo</body>', $opts );
		$parsedElement = $doc->getElementById( 'body' );
		$newElement = $doc->createElement( 'body' );
		$sameNs = ( $parsedElement->namespaceURI === $newElement->namespaceURI );
		return [
			// Parsing with these options results in elements with consistent
			// namespaceURI when you later use Document::createElement
			'goodNamespace' => $sameNs,
		];
	}

	/**
	 * Helper to benchmark the given function, pre-warming the cache and
	 * throwing away outliers.
	 */
	public static function benchmark( callable $func ): float {
		// Pre-warm caches etc by executing once untimed.
		$func();
		// Now execute a number of timed iterations
		$times = [];
		for ( $i = 0; $i < self::ITERATIONS;$i++ ) {
			$start = microtime( true );
			$func();
			$end = microtime( true );
			$times[] = $end - $start;
		}
		// Throw away highest and lowest
		if ( self::ITERATIONS > 2 ) {
			sort( $times, SORT_NUMERIC );
			array_pop( $times );
			array_shift( $times );
			if ( count( $times ) > 2 ) {
				array_pop( $times );
				array_shift( $times );
			}
		}
		$avgTime = 0;
		if ( count( $times ) > 0 ) {
			$avgTime = array_sum( $times ) / count( $times );
		}
		return round( $avgTime, self::ROUNDING );
	}

	public static function run() {
		$html = file_get_contents(
			# __DIR__ . '/../tests/Australia.html'
			__DIR__ . '/../tests/Barack_Obama.html'
		);
		$instance = new self( $html );
		$instance->execute();
	}

	private static function provideCases() {
		yield "DOMDocument with namespace" => [
			'suppressHtmlNamespace' => false,
		];
		yield "DOMDocument without namespace" => [
			'suppressHtmlNamespace' => true,
		];
		if ( class_exists( '\Dom\Document' ) ) {
			yield "\Dom\Document with namespace" => [
				'suppressHtmlNamespace' => false,
				'domImplementationClass' => \Dom\Implementation::class,
			];
			yield "\Dom\Document without namespace" => [
				'suppressHtmlNamespace' => true,
				'domImplementationClass' => \Dom\Implementation::class,
			];
		}
	}

	/** Run the benchmarks. */
	private function execute(): void {
		foreach ( self::provideCases() as $desc => $opts ) {
			$props = self::evalOpts( $opts );
			$time = self::benchmark( fn ()=>self::parse( $this->html, $opts ) );
			$propDesc = implode( ' ', array_keys( array_filter( $props, static fn ( $v ) => $v ) ) );
			echo( "$time - $desc $propDesc\n" );
		}
	}

	/**
	 * Parse the given $html using the supplied DOMBuilder options.
	 * @return \DOMDocument
	 */
	private static function parse( string $html, array $opts = [] ) {
		$domBuilder = new DOMBuilder( $opts );
		$treeBuilder = new TreeBuilder( $domBuilder, [ 'ignoreErrors' => true ] );
		$dispatcher = new Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer( $dispatcher, $html, [ 'ignoreErrors' => true ] );
		$tokenizer->execute( [] );
		return $domBuilder->getFragment();
	}
}
