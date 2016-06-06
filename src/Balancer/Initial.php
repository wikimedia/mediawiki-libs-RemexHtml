<?php

namespace Wikimedia\RemexHtml\Balancer;
use Wikimedia\RemexHtml\Tokenizer\Attributes;
use Wikimedia\RemexHtml\HTMLData;

class Initial extends InsertionMode {
	private static $allowedDoctypes = [
		[ 'html', '-//W3C//DTD HTML 4.0//EN', null ],
		[ 'html', '-//W3C//DTD HTML 4.0//EN', 'http://www.w3.org/TR/REC-html40/strict.dtd' ],
		[ 'html', '-//W3C//DTD HTML 4.01//EN', null ],
		[ 'html', '-//W3C//DTD HTML 4.01//EN', 'http://www.w3.org/TR/html4/strict.dtd' ],
		[ 'html', '-//W3C//DTD XHTML 1.0 Strict//EN',
			'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd' ],
		[ 'html', '-//W3C//DTD XHTML 1.1//EN', 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd' ]
	];

	function characters( $text, $start, $length, $sourceStart, $sourceLength ) {
		$wsLength = strspn( $text, "\t\n\f\r ", $start, $length );
		$length -= $wsLength;
		if ( !$length ) {
			return;
		}
		$start += $wsLength;
		if ( !$this->ignoreErrors && !$this->balancer->isIframeSrcdoc ) {
			$this->error( 'missing doctype', $sourceStart );
		}
		$this->dispatcher->switchMode( Dispatcher::BEFORE_HTML )
			->characters( $text, $start, $length, $sourceStart, $sourceLength );
	}

	function startTag( $name, Attributes $attrs, $selfClose, $sourceStart, $sourceLength ) {
		if ( !$this->ignoreErrors && !$this->balancer->isIframeSrcdoc ) {
			$this->error( 'missing doctype', $sourceStart );
		}
		$this->dispatcher->switchMode( Dispatcher::BEFORE_HTML )
			->startTag( $name, $attrs, $selfClose, $sourceStart, $sourceLength );
	}

	function endTag( $name, $sourceStart, $sourceLength ) {
		if ( !$this->ignoreErrors && !$this->balancer->isIframeSrcdoc ) {
			$this->error( 'missing doctype', $sourceStart );
		}
		$this->dispatcher->switchMode( Dispatcher::BEFORE_HTML )
			->endTag( $name, $sourceStart, $sourceLength );
	}

	function doctype( $name, $public, $system, $quirks, $sourceStart, $sourceLength ) {
		if ( !$this->ignoreErrors &&
			(
				$name !== 'html' || $public !== null
				|| ( $system !== null && $system !== 'about:legacy-compat' )
			)
			&& !in_array( [ $name, $public, $system ], self::$allowedDoctypes, true )
		) {
			$this->error( 'invalid doctype', $sourceStart );
		}

		$quirks = $quirks ? Balancer::QUIRKS : Balancer::NO_QUIRKS;

		$quirksIfNoSystem = '~-//W3C//DTD HTML 4\.01 Frameset//|' . 
			'-//W3C//DTD HTML 4\.01 Transitional//~Ai';
		$limitedQuirks = '~-//W3C//DTD XHTML 1\.0 Frameset//|' .
			'-//W3C//DTD XHTML 1\.0 Transitional//~Ai';

		if ( $name !== 'html'
			|| $public === '-//W3O//DTD W3 HTML Strict 3.0//EN//'
			|| $public === '-/W3C/DTD HTML 4.0 Transitional/EN'
			|| $public === 'HTML'
			|| $system === 'http://www.ibm.com/data/dtd/v11/ibmxhtml1-transitional.dtd'
			|| ( $system === null && preg_match( $quirksIfNoSystem, $public ) )
			|| preg_match( HTMLData::$quirkyPrefixRegex, $public )
		) {
			$quirks = Balancer::QUIRKS;
		} elseif ( !$this->balancer->isIframeSrcdoc
			&& ( 
				preg_match( $limitedQuirks, $public )
				|| ( $system !== null && preg_match( $quirksIfNoSystem, $public ) )
			)
		) {
			$quirks = Balancer::LIMITED_QUIRKS;
		}

		$name = $name === null ? '' : $name;
		$public = $public === null ? '' : $public;
		$system = $system === null ? '' : $system;
		$this->balancer->doctype( $name, $public, $system, $quirks,
			$sourceStart, $sourceLength );
		$this->dispatcher->switchMode( Dispatcher::BEFORE_HTML );
	}
}
