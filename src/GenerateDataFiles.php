<?php

namespace Wikimedia\RemexHtml;

/**
 * Generate HTMLData.php. This can be executed e.g. with
 *
 * echo 'Wikimedia\RemexHtml\GenerateDataFiles::run()' | hhvm bin/test.php
 */
class GenerateDataFiles {
	/**
	 * The only public entry point
	 */
	public static function run() {
		$instance = new self;
		$instance->execute();
	}

	/**
	 * This is the character entity mapping table copied from 
	 * https://www.w3.org/TR/2014/REC-html5-20141028/syntax.html#tokenizing-character-references
	 */
	private static $legacyNumericEntityData = <<<EOT
0x00 	U+FFFD 	REPLACEMENT CHARACTER
0x80 	U+20AC 	EURO SIGN (€)
0x82 	U+201A 	SINGLE LOW-9 QUOTATION MARK (‚)
0x83 	U+0192 	LATIN SMALL LETTER F WITH HOOK (ƒ)
0x84 	U+201E 	DOUBLE LOW-9 QUOTATION MARK („)
0x85 	U+2026 	HORIZONTAL ELLIPSIS (…)
0x86 	U+2020 	DAGGER (†)
0x87 	U+2021 	DOUBLE DAGGER (‡)
0x88 	U+02C6 	MODIFIER LETTER CIRCUMFLEX ACCENT (ˆ)
0x89 	U+2030 	PER MILLE SIGN (‰)
0x8A 	U+0160 	LATIN CAPITAL LETTER S WITH CARON (Š)
0x8B 	U+2039 	SINGLE LEFT-POINTING ANGLE QUOTATION MARK (‹)
0x8C 	U+0152 	LATIN CAPITAL LIGATURE OE (Œ)
0x8E 	U+017D 	LATIN CAPITAL LETTER Z WITH CARON (Ž)
0x91 	U+2018 	LEFT SINGLE QUOTATION MARK (‘)
0x92 	U+2019 	RIGHT SINGLE QUOTATION MARK (’)
0x93 	U+201C 	LEFT DOUBLE QUOTATION MARK (“)
0x94 	U+201D 	RIGHT DOUBLE QUOTATION MARK (”)
0x95 	U+2022 	BULLET (•)
0x96 	U+2013 	EN DASH (–)
0x97 	U+2014 	EM DASH (—)
0x98 	U+02DC 	SMALL TILDE (˜)
0x99 	U+2122 	TRADE MARK SIGN (™)
0x9A 	U+0161 	LATIN SMALL LETTER S WITH CARON (š)
0x9B 	U+203A 	SINGLE RIGHT-POINTING ANGLE QUOTATION MARK (›)
0x9C 	U+0153 	LATIN SMALL LIGATURE OE (œ)
0x9E 	U+017E 	LATIN SMALL LETTER Z WITH CARON (ž)
0x9F 	U+0178 	LATIN CAPITAL LETTER Y WITH DIAERESIS (Ÿ)
EOT;

	private function execute() {
		$entitiesJson = file_get_contents( __DIR__ . '/entities.json' );

		if ( $entitiesJson === false ) {
			throw new \Exception( "Please download entities.json from " .
				"https://www.w3.org/TR/2014/REC-html5-20141028/entities.json" );
		}

		$entities = (array)json_decode( $entitiesJson );

		$entityTranslations = [];
		foreach ( $entities as $entity => $info ) {
			$entityTranslations[substr( $entity, 1 )] = $info->characters;
		}

		// Sort descending by length
		uksort( $entities, function ( $a, $b ) {
			if ( strlen( $a ) > strlen( $b ) ) {
				return -1;
			} elseif ( strlen( $a ) < strlen( $b ) ) {
				return 1;
			} else {
				return strcmp( $a, $b );
			}
		} );

		$regex = '';
		foreach ( $entities as $entity => $unused ) {
			if ( $regex !== '' ) {
				$regex .= '|';
			}
			$regex .= "\n\t\t" . preg_quote( substr( $entity, 1 ), '~' );
		}

		$matches = [];
		preg_match_all( '/^0x([0-9A-F]+)\s+U\+([0-9A-F]+)/m',
			self::$legacyNumericEntityData, $matches, PREG_SET_ORDER );

		$legacyNumericEntities = [];
		foreach ( $matches as $match ) {
			$legacyNumericEntities[ intval( $match[1], 16 ) ] =
				Utils::codepointToUtf8( intval( $match[2], 16  ) );
		}

		$encRegex = var_export( $regex, true );
		$encTranslations = var_export( $entityTranslations, true );
		$encLegacy = var_export( $legacyNumericEntities, true );

		$fileContents = '<' . <<<PHP
?php

namespace Wikimedia\RemexHtml;

class HTMLData {
	static public \$namedEntityRegex = $encRegex;
	static public \$namedEntityTranslations = $encTranslations;
	static public \$legacyNumericEntities = $encLegacy;
}
PHP;

		file_put_contents( __DIR__ . '/HTMLData.php', $fileContents );
	}
}
