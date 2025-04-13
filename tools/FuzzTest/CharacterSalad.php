<?php

namespace Wikimedia\RemexHtml\Tools\FuzzTest;

/**
 * A generator for a random strings, biased towards characters that have
 * special meaning in HTML.
 */
class CharacterSalad {
	/** @var int */
	private $minLength;
	/** @var int */
	private $maxLength;
	/** @var mixed[] */
	private $bigDictionary;
	private const SMALL_DICTIONARY = [
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

	public function __construct( int $minLength, int $maxLength ) {
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
		$this->bigDictionary = Utils::getBigDictionary();
	}

	public function next(): string {
		$length = mt_rand( $this->minLength, $this->maxLength );
		$s = '';
		for ( $i = 0; $i < $length; $i++ ) {
			if ( Utils::coinToss( 0.5 ) ) {
				$s .= Utils::pickRandom( $this->bigDictionary );
			} else {
				$s .= Utils::pickRandom( self::SMALL_DICTIONARY );
			}
		}
		return $s;
	}
}
