<?php

namespace Wikimedia\RemexHtml\FuzzTest;

/**
 * A generator for a random strings, biased towards characters that have
 * special meaning in HTML.
 */
class CharacterSalad {
	private $minLength;
	private $maxLength;
	private $bigDictionary;
	private static $smallDictionary = [
		'<',
		'>',
		'&',
		';',
		'/',
		'=',
		'"',
		'\'',
		'=',
		'a',
		'b',
		'c',
	];

	public function __construct( $minLength, $maxLength ) {
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
		$this->bigDictionary = Utils::getBigDictionary();
	}

	public function next() {
		$length = mt_rand( $this->minLength, $this->maxLength );
		$s = '';
		for ( $i = 0; $i < $length; $i++ ) {
			if ( Utils::coinToss( 0.5 ) ) {
				$s .= Utils::pickRandom( $this->bigDictionary );
			} else {
				$s .= Utils::pickRandom( self::$smallDictionary );
			}
		}
		return $s;
	}
}

// Retain the old namespace for backwards compatibility.
class_alias( CharacterSalad::class, 'RemexHtml\FuzzTest\CharacterSalad' );
