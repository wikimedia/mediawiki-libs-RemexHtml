<?php

namespace Wikimedia\RemexHtml\Tests;

// These deliberately use the old aliased namespace.
use RemexHtml\DOM\DOMBuilder;
use RemexHtml\HTMLData;
use RemexHtml\Tokenizer\Tokenizer;
use RemexHtml\TreeBuilder\Dispatcher;
use RemexHtml\TreeBuilder\TreeBuilder;

class AliasTest extends \PHPUnit\Framework\TestCase {
	public function testHTMLData() {
		// Basic test that HTMLData is properly aliased
		$this->assertEquals( 'http://www.w3.org/1999/xhtml', HTMLData::NS_HTML );
	}

	public function testParse() {
		// Very simple HTML parse, but with the aliased names.
		$html = '<p>Hello, <b>world!';
		$domBuilder = new DOMBuilder( [
			'suppressHtmlNamespace' => true,
		] );
		$treeBuilder = new TreeBuilder( $domBuilder, [
			'ignoreErrors' => true,
		] );
		$dispatcher = new Dispatcher( $treeBuilder );
		$tokenizer = new Tokenizer( $dispatcher, $html, [
			'ignoreErrors' => true,
		] );
		$tokenizer->execute( [
		] );
		$this->assertFalse( $domBuilder->isCoerced() );
		$frag = $domBuilder->getFragment();
		'@phan-var \DOMDocument $frag'; // @var \DOMDocument $frag
		// The most important this is that we didn't crash getting here.
		$this->assertSame(
			"<html><head></head><body><p>Hello, <b>world!</b></p></body></html>\n",
			$frag->saveHTML()
		);
	}
}
