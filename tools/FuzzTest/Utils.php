<?php

namespace Wikimedia\RemexHtml\Tools\FuzzTest;

class Utils {
	private static $bigDictionary = null;

	/**
	 * Generate a pseudorandom boolean value.
	 *
	 * @param float $p The probability of the function returning true
	 * @return bool
	 */
	public static function coinToss( $p ) {
		return mt_rand() / mt_getrandmax() < $p;
	}

	/**
	 * Given an array with consecutive zero-based integer keys, pick a
	 * pseudorandom element and return the value.
	 *
	 * @param array $array
	 * @return mixed
	 */
	public static function pickRandom( $array ) {
		return $array[ mt_rand( 0, count( $array ) - 1 ) ];
	}

	/**
	 * Get a dictionary containing many strings which may be relevant to HTML
	 * parsing. The file used here, validatornu-dictionary, is derived from a
	 * list of string literals in the validator.nu HTML parser code base.
	 *
	 * @return string[]
	 */
	public static function getBigDictionary() {
		if ( self::$bigDictionary === null ) {
			$dict = [];
			foreach ( file( __DIR__ . '/validatornu-dictionary' ) as $line ) {
				$value = json_decode( '"' . rtrim( $line, "\n" ) . '"' );
				$dict[] = $value;
			}
			self::$bigDictionary = $dict;
		}
		return self::$bigDictionary;
	}
}
