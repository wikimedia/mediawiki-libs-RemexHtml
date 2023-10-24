<?php

namespace Wikimedia\RemexHtml\Tools;

use Wikimedia\RemexHtml\Tokenizer\Tokenizer;

/**
 * Generate HTMLData.php. This can be executed e.g. with
 *
 * echo 'Wikimedia\RemexHtml\Tools\GenerateDataFiles::run()' | php bin/test.php
 *
 * or, using the psysh shell from the project root directory:
 *
 * >>> require('vendor/autoload.php');
 * >>> Wikimedia\RemexHtml\Tools\GenerateDataFiles::run()
 *
 * or, using composer:
 *
 * composer generate-htmldata
 */
class GenerateDataFiles {
	private const NS_HTML = 'http://www.w3.org/1999/xhtml';
	private const NS_MATHML = 'http://www.w3.org/1998/Math/MathML';
	private const NS_SVG = 'http://www.w3.org/2000/svg';
	private const NS_XLINK = 'http://www.w3.org/1999/xlink';
	private const NS_XML = 'http://www.w3.org/XML/1998/namespace';
	private const NS_XMLNS = 'http://www.w3.org/2000/xmlns/';

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
	 *
	 * @var string
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

	/**
	 * This is the list of public identifier prefixes that cause quirks mode
	 * to be set, from § 8.2.5.4.1
	 *
	 * @var array
	 */
	private static $quirkyPublicPrefixes = [
		"+//Silmaril//dtd html Pro v0r11 19970101//",
		"-//AS//DTD HTML 3.0 asWedit + extensions//",
		"-//AdvaSoft Ltd//DTD HTML 3.0 asWedit + extensions//",
		"-//IETF//DTD HTML 2.0 Level 1//",
		"-//IETF//DTD HTML 2.0 Level 2//",
		"-//IETF//DTD HTML 2.0 Strict Level 1//",
		"-//IETF//DTD HTML 2.0 Strict Level 2//",
		"-//IETF//DTD HTML 2.0 Strict//",
		"-//IETF//DTD HTML 2.0//",
		"-//IETF//DTD HTML 2.1E//",
		"-//IETF//DTD HTML 3.0//",
		"-//IETF//DTD HTML 3.2 Final//",
		"-//IETF//DTD HTML 3.2//",
		"-//IETF//DTD HTML 3//",
		"-//IETF//DTD HTML Level 0//",
		"-//IETF//DTD HTML Level 1//",
		"-//IETF//DTD HTML Level 2//",
		"-//IETF//DTD HTML Level 3//",
		"-//IETF//DTD HTML Strict Level 0//",
		"-//IETF//DTD HTML Strict Level 1//",
		"-//IETF//DTD HTML Strict Level 2//",
		"-//IETF//DTD HTML Strict Level 3//",
		"-//IETF//DTD HTML Strict//",
		"-//IETF//DTD HTML//",
		"-//Metrius//DTD Metrius Presentational//",
		"-//Microsoft//DTD Internet Explorer 2.0 HTML Strict//",
		"-//Microsoft//DTD Internet Explorer 2.0 HTML//",
		"-//Microsoft//DTD Internet Explorer 2.0 Tables//",
		"-//Microsoft//DTD Internet Explorer 3.0 HTML Strict//",
		"-//Microsoft//DTD Internet Explorer 3.0 HTML//",
		"-//Microsoft//DTD Internet Explorer 3.0 Tables//",
		"-//Netscape Comm. Corp.//DTD HTML//",
		"-//Netscape Comm. Corp.//DTD Strict HTML//",
		"-//O'Reilly and Associates//DTD HTML 2.0//",
		"-//O'Reilly and Associates//DTD HTML Extended 1.0//",
		"-//O'Reilly and Associates//DTD HTML Extended Relaxed 1.0//",
		"-//SoftQuad Software//DTD HoTMetaL PRO 6.0::19990601::extensions to HTML 4.0//",
		"-//SoftQuad//DTD HoTMetaL PRO 4.0::19971010::extensions to HTML 4.0//",
		"-//Spyglass//DTD HTML 2.0 Extended//",
		"-//SQ//DTD HTML 2.0 HoTMetaL + extensions//",
		"-//Sun Microsystems Corp.//DTD HotJava HTML//",
		"-//Sun Microsystems Corp.//DTD HotJava Strict HTML//",
		"-//W3C//DTD HTML 3 1995-03-24//",
		"-//W3C//DTD HTML 3.2 Draft//",
		"-//W3C//DTD HTML 3.2 Final//",
		"-//W3C//DTD HTML 3.2//",
		"-//W3C//DTD HTML 3.2S Draft//",
		"-//W3C//DTD HTML 4.0 Frameset//",
		"-//W3C//DTD HTML 4.0 Transitional//",
		"-//W3C//DTD HTML Experimental 19960712//",
		"-//W3C//DTD HTML Experimental 970421//",
		"-//W3C//DTD W3 HTML//",
		"-//W3O//DTD W3 HTML 3.0//",
		"-//WebTechs//DTD Mozilla HTML 2.0//",
		"-//WebTechs//DTD Mozilla HTML//",
	];

	private static $special = [
		self::NS_HTML => 'address, applet, area, article, aside, base,
			basefont, bgsound, blockquote, body, br, button, caption, center,
			col, colgroup, dd, details, dir, div, dl, dt, embed, fieldset,
			figcaption, figure, footer, form, frame, frameset, h1, h2, h3, h4,
			h5, h6, head, header, hr, html, iframe, img, input, li, link,
			listing, main, marquee, menu, menuitem, meta, nav, noembed,
			noframes, noscript, object, ol, p, param, plaintext, pre, script,
			section, select, source, style, summary, table, tbody, td, template,
			textarea, tfoot, th, thead, title, tr, track, ul, wbr, xmp',
		self::NS_MATHML => 'mi, mo, mn, ms, mtext, annotation-xml',
		self::NS_SVG => 'foreignObject, desc, title',
	];

	// phpcs:disable Generic.Files.LineLength
	/**
	 * The NameStartChar production from XML 1.0, but with colon excluded since
	 * there's a lot of ways to break namespace validation, and we actually need
	 * this for local names
	 *
	 * @var string
	 */
	private static $nameStartChar = '[A-Z] | "_" | [a-z] | [#xC0-#xD6] | [#xD8-#xF6] | [#xF8-#x2FF] | [#x370-#x37D] | [#x37F-#x1FFF] | [#x200C-#x200D] | [#x2070-#x218F] | [#x2C00-#x2FEF] | [#x3001-#xD7FF] | [#xF900-#xFDCF] | [#xFDF0-#xFFFD] | [#x10000-#xEFFFF]';

	/**
	 * The NameChar production from XML 1.0
	 *
	 * @var string
	 */
	private static $nameChar = 'NameStartChar | "-" | "." | [0-9] | #xB7 | [#x0300-#x036F] | [#x203F-#x2040]';

	/**
	 * The actual set of allowed NameStartChar characters from libxml2's
	 * xmlValidateName function, which is
	 *   IS_LETTER = IS_BASECHAR || IS_IDEOGRAPHIC
	 * plus '_'.
	 *
	 * We exclude ':' for the same reason as for $nameStartChar.
	 *
	 * @var string
	 */
	private static $libxml2NameStartChar = '[A-Z] | "_" | [a-z] | [#xC0-#xD6] | [#xD8-#xF6] | [#xF8-#x131] | [#x134-#x13E] | [#x141-#x148] | [#x14A-#x17E] | [#x180-#x1C3] | [#x1CD-#x1F0] | [#x1F4-#x1F5] | [#x1FA-#x217] | [#x250-#x2A8] | [#x2BB-#x2C1] | #x386 | [#x388-#x38A] | #x38C | [#x38E-#x3A1] | [#x3A3-#x3CE] | [#x3D0-#x3D6] | #x3DA | #x3DC | #x3DE | #x3E0 | [#x3E2-#x3F3] | [#x401-#x40C] | [#x40E-#x44F] | [#x451-#x45C] | [#x45E-#x481] | [#x490-#x4C4] | [#x4C7-#x4C8] | [#x4CB-#x4CC] | [#x4D0-#x4EB] | [#x4EE-#x4F5] | [#x4F8-#x4F9] | [#x531-#x556] | #x559 | [#x561-#x586] | [#x5D0-#x5EA] | [#x5F0-#x5F2] | [#x621-#x63A] | [#x641-#x64A] | [#x671-#x6B7] | [#x6BA-#x6BE] | [#x6C0-#x6CE] | [#x6D0-#x6D3] | #x6D5 | [#x6E5-#x6E6] | [#x905-#x939] | #x93D | [#x958-#x961] | [#x985-#x98C] | [#x98F-#x990] | [#x993-#x9A8] | [#x9AA-#x9B0] | #x9B2 | [#x9B6-#x9B9] | [#x9DC-#x9DD] | [#x9DF-#x9E1] | [#x9F0-#x9F1] | [#xA05-#xA0A] | [#xA0F-#xA10] | [#xA13-#xA28] | [#xA2A-#xA30] | [#xA32-#xA33] | [#xA35-#xA36] | [#xA38-#xA39] | [#xA59-#xA5C] | #xA5E | [#xA72-#xA74] | [#xA85-#xA8B] | #xA8D | [#xA8F-#xA91] | [#xA93-#xAA8] | [#xAAA-#xAB0] | [#xAB2-#xAB3] | [#xAB5-#xAB9] | #xABD | #xAE0 | [#xB05-#xB0C] | [#xB0F-#xB10] | [#xB13-#xB28] | [#xB2A-#xB30] | [#xB32-#xB33] | [#xB36-#xB39] | #xB3D | [#xB5C-#xB5D] | [#xB5F-#xB61] | [#xB85-#xB8A] | [#xB8E-#xB90] | [#xB92-#xB95] | [#xB99-#xB9A] | #xB9C | [#xB9E-#xB9F] | [#xBA3-#xBA4] | [#xBA8-#xBAA] | [#xBAE-#xBB5] | [#xBB7-#xBB9] | [#xC05-#xC0C] | [#xC0E-#xC10] | [#xC12-#xC28] | [#xC2A-#xC33] | [#xC35-#xC39] | [#xC60-#xC61] | [#xC85-#xC8C] | [#xC8E-#xC90] | [#xC92-#xCA8] | [#xCAA-#xCB3] | [#xCB5-#xCB9] | #xCDE | [#xCE0-#xCE1] | [#xD05-#xD0C] | [#xD0E-#xD10] | [#xD12-#xD28] | [#xD2A-#xD39] | [#xD60-#xD61] | [#xE01-#xE2E] | #xE30 | [#xE32-#xE33] | [#xE40-#xE45] | [#xE81-#xE82] | #xE84 | [#xE87-#xE88] | #xE8A | #xE8D | [#xE94-#xE97] | [#xE99-#xE9F] | [#xEA1-#xEA3] | #xEA5 | #xEA7 | [#xEAA-#xEAB] | [#xEAD-#xEAE] | #xEB0 | [#xEB2-#xEB3] | #xEBD | [#xEC0-#xEC4] | [#xF40-#xF47] | [#xF49-#xF69] | [#x10A0-#x10C5] | [#x10D0-#x10F6] | #x1100 | [#x1102-#x1103] | [#x1105-#x1107] | #x1109 | [#x110B-#x110C] | [#x110E-#x1112] | #x113C | #x113E | #x1140 | #x114C | #x114E | #x1150 | [#x1154-#x1155] | #x1159 | [#x115F-#x1161] | #x1163 | #x1165 | #x1167 | #x1169 | [#x116D-#x116E] | [#x1172-#x1173] | #x1175 | #x119E | #x11A8 | #x11AB | [#x11AE-#x11AF] | [#x11B7-#x11B8] | #x11BA | [#x11BC-#x11C2] | #x11EB | #x11F0 | #x11F9 | [#x1E00-#x1E9B] | [#x1EA0-#x1EF9] | [#x1F00-#x1F15] | [#x1F18-#x1F1D] | [#x1F20-#x1F45] | [#x1F48-#x1F4D] | [#x1F50-#x1F57] | #x1F59 | #x1F5B | #x1F5D | [#x1F5F-#x1F7D] | [#x1F80-#x1FB4] | [#x1FB6-#x1FBC] | #x1FBE | [#x1FC2-#x1FC4] | [#x1FC6-#x1FCC] | [#x1FD0-#x1FD3] | [#x1FD6-#x1FDB] | [#x1FE0-#x1FEC] | [#x1FF2-#x1FF4] | [#x1FF6-#x1FFC] | #x2126 | [#x212A-#x212B] | #x212E | [#x2180-#x2182] | #x3007 | [#x3021-#x3029] | [#x3041-#x3094] | [#x30A1-#x30FA] | [#x3105-#x312C] | [#x4E00-#x9FA5] | [#xAC00-#xD7A3]';

	/**
	 * The actual set of allowed NameChar characters from libxml2's
	 * xmlValidateName function, which extends the NameStartChar characters
	 * with
	 *   IS_DIGIT || '.' || '-' || IS_COMBINING || IS_EXTENDER
	 *
	 * @var string
	 */
	private static $libxml2NameChar = 'NameStartChar | "-" | "." | [0-9] | #xB7 | [#x2D0-#x2D1] | [#x300-#x345] | [#x360-#x361] | #x387 | [#x483-#x486] | [#x591-#x5A1] | [#x5A3-#x5B9] | [#x5BB-#x5BD] | #x5BF | [#x5C1-#x5C2] | #x5C4 | #x640 | [#x64B-#x652] | [#x660-#x669] | #x670 | [#x6D6-#x6E4] | [#x6E7-#x6E8] | [#x6EA-#x6ED] | [#x6F0-#x6F9] | [#x901-#x903] | #x93C | [#x93E-#x94D] | [#x951-#x954] | [#x962-#x963] | [#x966-#x96F] | [#x981-#x983] | #x9BC | [#x9BE-#x9C4] | [#x9C7-#x9C8] | [#x9CB-#x9CD] | #x9D7 | [#x9E2-#x9E3] | [#x9E6-#x9EF] | #xA02 | #xA3C | [#xA3E-#xA42] | [#xA47-#xA48] | [#xA4B-#xA4D] | [#xA66-#xA71] | [#xA81-#xA83] | #xABC | [#xABE-#xAC5] | [#xAC7-#xAC9] | [#xACB-#xACD] | [#xAE6-#xAEF] | [#xB01-#xB03] | #xB3C | [#xB3E-#xB43] | [#xB47-#xB48] | [#xB4B-#xB4D] | [#xB56-#xB57] | [#xB66-#xB6F] | [#xB82-#xB83] | [#xBBE-#xBC2] | [#xBC6-#xBC8] | [#xBCA-#xBCD] | #xBD7 | [#xBE7-#xBEF] | [#xC01-#xC03] | [#xC3E-#xC44] | [#xC46-#xC48] | [#xC4A-#xC4D] | [#xC55-#xC56] | [#xC66-#xC6F] | [#xC82-#xC83] | [#xCBE-#xCC4] | [#xCC6-#xCC8] | [#xCCA-#xCCD] | [#xCD5-#xCD6] | [#xCE6-#xCEF] | [#xD02-#xD03] | [#xD3E-#xD43] | [#xD46-#xD48] | [#xD4A-#xD4D] | #xD57 | [#xD66-#xD6F] | #xE31 | [#xE34-#xE3A] | [#xE46-#xE4E] | [#xE50-#xE59] | #xEB1 | [#xEB4-#xEB9] | [#xEBB-#xEBC] | #xEC6 | [#xEC8-#xECD] | [#xED0-#xED9] | [#xF18-#xF19] | [#xF20-#xF29] | #xF35 | #xF37 | #xF39 | [#xF3E-#xF3F] | [#xF71-#xF84] | [#xF86-#xF8B] | [#xF90-#xF95] | #xF97 | [#xF99-#xFAD] | [#xFB1-#xFB7] | #xFB9 | [#x20D0-#x20DC] | #x20E1 | #x3005 | [#x302A-#x302F] | [#x3031-#x3035] | [#x3099-#x309A] | [#x309D-#x309E] | [#x30FC-#x30FE]';
	// phpcs:enable

	/**
	 * Build a regex alternation from an array of ampersand-prefixed entity
	 * names.
	 * @param string[] $array
	 * @return string
	 */
	private function makeRegexAlternation( $array ) {
		$regex = '';
		foreach ( $array as $value ) {
			if ( $regex !== '' ) {
				$regex .= '|';
			}
			$regex .= "\n\t\t" . preg_quote( substr( $value, 1 ), '~' );
		}
		return $regex;
	}

	private function getCharRanges( $input, $nonterminals = [] ) {
		$ranges = [];

		foreach ( preg_split( '/\s*\|\s*/', $input ) as $case ) {
			if ( preg_match( '/^"(.)"$/', $case, $m ) ) {
				// Single ASCII character
				$ranges[] = [ ord( $m[1] ), ord( $m[1] ) ];
			} elseif ( preg_match( '/^\[(.)-(.)\]$/', $case, $m ) ) {
				// ASCII range
				$ranges[] = [ ord( $m[1] ), ord( $m[2] ) ];
			} elseif ( preg_match( '/^#x([0-9A-F]+)$/', $case, $m ) ) {
				// Single encoded character
				$codepoint = intval( $m[1], 16 );
				$ranges[] = [ $codepoint, $codepoint ];
			} elseif ( preg_match( '/^\[#x([0-9A-F]+)-#x([0-9A-F]+)\]$/', $case, $m ) ) {
				// Encoded range
				$ranges[] = [ intval( $m[1], 16 ), intval( $m[2], 16 ) ];
			} elseif ( isset( $nonterminals[$case] ) ) {
				$ranges = array_merge( $ranges, $this->getCharRanges( $nonterminals[$case] ) );
			} else {
				throw new \Exception( "Invalid XML char case \"$case\"" );
			}
		}
		usort( $ranges, static function ( $a, $b ) {
			return $a[0] - $b[0];
		} );
		return $ranges;
	}

	private function makeConvTable( $input, $nonterminals = [] ) {
		$ranges = $this->getCharRanges( $input, $nonterminals );

		// Invert the ranges, produce a set complement
		$lastEndPlusOne = 0;
		$table = [];
		for ( $i = 0; $i < count( $ranges ); $i++ ) {
			$start = $ranges[$i][0];
			$end = $ranges[$i][1];
			// Merge consecutive ranges
			for ( $j = $i + 1; $j < count( $ranges ); $j++ ) {
				if ( $ranges[$j][0] === $end + 1 ) {
					$end = $ranges[$j][1];
					$i = $j;
				} else {
					break;
				}
			}

			$table[] = $lastEndPlusOne;
			$table[] = $start - 1;
			$table[] = 0;
			$table[] = 0xffffff;

			$lastEndPlusOne = $end + 1;
		}

		// Last range
		$table[] = $lastEndPlusOne;
		$table[] = 0x10ffff;
		$table[] = 0;
		$table[] = 0xffffff;

		return $table;
	}

	private function encodeConvTable( $table ) {
		return "[\n\t\t" . implode( ",\n\t\t", array_map(
			static function ( $a ) {
				return implode( ', ', $a );
			},
			array_chunk( $table, 4 ) ) ) . ' ]';
	}

	/**
	 * Like var_export(), but more conforming to our standard code style.
	 * @param mixed $obj
	 * @param int $indent The desired additional indentation level
	 * @return string
	 */
	private static function phpExport( $obj, $indent = 0 ): string {
		if ( !is_array( $obj ) ) {
			return var_export( $obj, true );
		}
		$tabs = str_repeat( "\t", $indent );
		$s = "[\n";
		foreach ( $obj as $key => $value ) {
			$s .= "$tabs\t" . var_export( $key, true ) . ' => ';
			$s .= self::phpExport( $value, $indent + 1 );
			$s .= ",\n";
		}
		$s .= "$tabs]";
		return $s;
	}

	private function execute() {
		$filename = __DIR__ . '/entities.json';
		$entitiesJson = file_exists( $filename ) ?
			file_get_contents( $filename ) : false;

		if ( $entitiesJson === false ) {
			throw new \Exception( "Please download entities.json from " .
				"https://www.w3.org/TR/2016/REC-html51-20161101/entities.json" );
		}

		$entities = (array)json_decode( $entitiesJson );

		$entityTranslations = [];
		foreach ( $entities as $entity => $info ) {
			$entityTranslations[substr( $entity, 1 )] = $info->characters;
		}

		// Sort descending by length
		uksort( $entities, static function ( $a, $b ) {
			if ( strlen( $a ) > strlen( $b ) ) {
				return -1;
			} elseif ( strlen( $a ) < strlen( $b ) ) {
				return 1;
			} else {
				return strcmp( $a, $b );
			}
		} );

		$entityRegex = $this->makeRegexAlternation( array_keys( $entities ) );
		$charRefRegex = str_replace(
			'{{NAMED_ENTITY_REGEX}}', $entityRegex, Tokenizer::CHARREF_REGEX
		);

		$matches = [];
		preg_match_all( '/^0x([0-9A-F]+)\s+U\+([0-9A-F]+)/m',
			self::$legacyNumericEntityData, $matches, PREG_SET_ORDER );

		$legacyNumericEntities = [];
		foreach ( $matches as $match ) {
			$legacyNumericEntities[ intval( $match[1], 16 ) ] =
				\UtfNormal\Utils::codepointToUtf8( intval( $match[2], 16 ) );
		}

		$quirkyRegex =
			'~' .
			$this->makeRegexAlternation( self::$quirkyPublicPrefixes ) .
			'~xAi';

		$nameStartCharConvTable = $this->makeConvTable( self::$libxml2NameStartChar );
		$nameCharConvTable = $this->makeConvTable( self::$libxml2NameChar,
			[ 'NameStartChar' => self::$libxml2NameStartChar ] );

		$encEntityRegex = self::phpExport( $entityRegex, 1 );
		$encCharRefRegex = self::phpExport( $charRefRegex, 1 );
		$encTranslations = self::phpExport( $entityTranslations, 1 );
		$encLegacy = self::phpExport( $legacyNumericEntities, 1 );
		$encQuirkyRegex = self::phpExport( $quirkyRegex, 1 );
		$encNameStartCharConvTable = $this->encodeConvTable( $nameStartCharConvTable );
		$encNameCharConvTable = $this->encodeConvTable( $nameCharConvTable );

		$special = [];
		foreach ( self::$special as $ns => $str ) {
			foreach ( explode( ',', $str ) as $name ) {
				$special[$ns][trim( $name )] = true;
			}
		}
		$encSpecial = self::phpExport( $special, 1 );

		$nsHtml = self::phpExport( self::NS_HTML, 1 );
		$nsMathML = self::phpExport( self::NS_MATHML, 1 );
		$nsSvg = self::phpExport( self::NS_SVG, 1 );
		$nsXlink = self::phpExport( self::NS_XLINK, 1 );
		$nsXml = self::phpExport( self::NS_XML, 1 );
		$nsXmlNs = self::phpExport( self::NS_XMLNS, 1 );

		$fileContents = '<' . <<<PHP
?php

/**
 * This data file is machine generated, see tools/GenerateDataFiles.php
 */

namespace Wikimedia\RemexHtml;

class HTMLData {
	public const NS_HTML = $nsHtml;
	public const NS_MATHML = $nsMathML;
	public const NS_SVG = $nsSvg;
	public const NS_XLINK = $nsXlink;
	public const NS_XML = $nsXml;
	public const NS_XMLNS = $nsXmlNs;

	public static \$special = $encSpecial;
	public static \$namedEntityRegex = $encEntityRegex;
	public static \$charRefRegex = $encCharRefRegex;
	public static \$namedEntityTranslations = $encTranslations;
	public static \$legacyNumericEntities = $encLegacy;
	public static \$quirkyPrefixRegex = $encQuirkyRegex;
	public static \$nameStartCharConvTable = $encNameStartCharConvTable;
	public static \$nameCharConvTable = $encNameCharConvTable;
}

PHP;

		file_put_contents( __DIR__ . '/../src/HTMLData.php', $fileContents );
	}
}
