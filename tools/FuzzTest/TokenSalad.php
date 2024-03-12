<?php

namespace Wikimedia\RemexHtml\Tools\FuzzTest;

use Wikimedia\RemexHtml\HTMLData;

/**
 * A generator which produces pseudorandom strings that mostly look like valid
 * HTML tokens, with tag names that are often valid HTML tag names.
 */
class TokenSalad {
	private const TOKEN_CHARACTER = 0;
	private const TOKEN_START = 1;
	private const TOKEN_END = 2;
	private const TOKEN_DOCTYPE = 3;
	private const TOKEN_COMMENT = 4;
	private const TOKEN_MAX = 4;

	private $maxLength;
	private $bigDictionary;
	private $specialTags;
	private $characterSalad;
	private $entities;

	private static $elementNameBlacklist = '/^(menu|isindex)/i';

	public function __construct( $maxLength ) {
		$this->maxLength = $maxLength;
		$this->bigDictionary = Utils::getBigDictionary();
		$this->specialTags = array_keys(
			HTMLData::$special[HTMLData::NS_HTML] +
			HTMLData::$special[HTMLData::NS_MATHML] +
			HTMLData::$special[HTMLData::NS_SVG] );
		$this->entities = array_keys( HTMLData::$namedEntityTranslations );
		$this->characterSalad = new CharacterSalad( 0, 4 );
	}

	public function next() {
		$length = mt_rand( 0, $this->maxLength );
		$s = '';

		for ( $i = 0; $i < $length; $i++ ) {
			if ( $i === 0 && Utils::coinToss( 0.5 ) ) {
				$type = self::TOKEN_DOCTYPE;
			} else {
				$type = mt_rand( 0, self::TOKEN_MAX );
			}
			switch ( $type ) {
			case self::TOKEN_CHARACTER:
				if ( Utils::coinToss( 0.2 ) ) {
					$s .= '&' . Utils::pickRandom( $this->entities );
				} else {
					$s .= $this->characterSalad->next();
				}
				break;

			case self::TOKEN_START:
			case self::TOKEN_END:
				$name = $this->getElementName();
				$s .= '<';
				if ( $type === self::TOKEN_END ) {
					$s .= '/';
				}
				$s .= "<$name";
				if ( Utils::coinToss( 0.5 ) ) {
					$numAttribs = mt_rand( 1, 3 );
					for ( $j = 0; $j < $numAttribs; $j++ ) {
						$name = $this->getAttributeName();
						$value = $this->getAttributeValue();
						if ( Utils::coinToss( 0.25 ) ) {
							$s .= " $name";
						} else {
							$quote = $this->getQuote();
							$s .= " $name=$quote$value$quote";
						}
					}
				}
				if ( Utils::coinToss( 0.2 ) ) {
					$s .= '/';
				}
				$s .= '>';
				break;

			case self::TOKEN_DOCTYPE:
				if ( Utils::coinToss( 0.5 ) ) {
					$s .= '<!doctype';
				} else {
					$s .= '<!DOCTYPE';
				}

				[ $name, $public, $system ] = $this->getDoctype();
				$quote = $this->getQuote();
				$s .= " $name";
				if ( $public !== null ) {
					$s .= " PUBLIC $quote$public$quote";
				}
				if ( $system !== null ) {
					$s .= " SYSTEM $quote$system$quote";
				}
				$s .= '>';
				break;

			case self::TOKEN_COMMENT:
				$s .= '<!--' . $this->characterSalad->next() . '-->';
				break;
			}
		}
		return $s;
	}

	private function getElementName() {
		do {
			if ( Utils::coinToss( 0.5 ) ) {
				if ( Utils::coinToss( 0.5 ) ) {
					$name = Utils::pickRandom( $this->specialTags );
				} else {
					$name = Utils::pickRandom( FuzzData::$w3schoolsTagNames );
				}
			} else {
				$name = Utils::pickRandom( $this->bigDictionary );
			}
		} while ( preg_match( self::$elementNameBlacklist, $name ) );
		return $name;
	}

	private function getAttributeName() {
		if ( Utils::coinToss( 0.5 ) ) {
			return Utils::pickRandom( FuzzData::$attributeNames );
		} else {
			return Utils::pickRandom( $this->bigDictionary );
		}
	}

	private function getAttributeValue() {
		if ( Utils::coinToss( 0.5 ) ) {
			return Utils::pickRandom( FuzzData::$attributeValues );
		} else {
			return $this->characterSalad->next();
		}
	}

	private function getQuote() {
		switch ( mt_rand( 0, 2 ) ) {
		case 0:
			return '';
		case 1:
			return '"';
		default:
			return "'";
		}
	}

	private function getDoctype() {
		if ( Utils::coinToss( 0.5 ) ) {
			$name = 'html';
		} else {
			$name = $this->characterSalad->next();
		}
		if ( Utils::coinToss( 0.5 ) ) {
			$public = null;
		} else {
			$public = Utils::pickRandom( $this->bigDictionary );
		}
		if ( Utils::coinToss( 0.5 ) ) {
			$system = null;
		} else {
			$system = Utils::pickRandom( $this->bigDictionary );
		}
		return [ $name, $public, $system ];
	}

}
