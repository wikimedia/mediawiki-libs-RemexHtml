<?php
// phpcs:disable Generic.Files.LineLength.TooLong

// Originally from: https://github.com/AbcAeffchen/doxygen-php-filters
// Commit: f13305bd4996bc1b6fcd153f32f7136187b9dd6d
/**
 * Project: doxygen-php-filters
 * User:    Alex Schickedanz (AbcAeffchen)
 * Date:    05.03.2015
 * License: GPL v2.0
 */

// Input
$source = file_get_contents( $argv[1] );

// support short array syntax
$regexp = '#((var|public|protected|private)(\s+static)?)\s+(\$[^\s;=]+)\s+\=\s+\[([\s\S]*?)\]\;#';
$replace = '$1 $4 = array( $5 );';
$source = preg_replace( $regexp, $replace, $source );

// add class member type hints
$regexp = '#\@(var|type)\s+([^\s]+)([^/]+)/\s+(var|public|protected|private)(\s+static)?\s+(\$[^\s;=]+)#';
$replace = '$3 */ $4 $5 $2 $6';
$source = preg_replace( $regexp, $replace, $source );

// add type hinting to methods
$regexp = '#(\/\*\*[\s\S]*?@return\s+([^\s]*)[\s\S]*?\*\/[\s\S]*?)((?:final\s+)?(?:public|protected|private)(?:\s+static)?)\s+function\s+([\S]*?)\s*?\(#';
$replace = '$1 $3 $2 function $4(';
$source = preg_replace( $regexp, $replace, $source );

$regexp = '#(\*\/\s*?)((?:final\s+)?(?:public|protected|private)(?:\s+static)?)\s+(function\s+(?:[^\s\(]*?)\s*\([^\)]*\)\s*:\s*)((?!void)[^\s\{]*)#m';
$replace = '$1$2 $4 $3$4';
$source = preg_replace( $regexp, $replace, $source );

// change "@return $this" to '@return [ClassName]'
$tokens = token_get_all( $source );
$classes = [];
foreach ( $tokens as $key => $token ) {
	if ( $token[0] == T_CLASS ) {
		$classes[] = $tokens[$key + 2][1];
	}
}

if ( !empty( $classes ) ) {
	[ $source, $tail ] = explode( 'class ' . $classes[0], $source, 2 );
	$class_code = '';
	for ( $i = 1; $i < count( $classes ); $i++ ) {
		[ $class_code, $tail ] = explode( 'class ' . $classes[$i], $tail, 2 );
		$class_code = str_replace( '@return $this', '@return ' . $classes[$i - 1], $class_code );
		$source .= 'class ' . $classes[$i - 1] . $class_code;
	}
	$class_code = str_replace( '@return $this', '@return ' . $classes[count( $classes ) - 1], $tail );
	$source .= 'class ' . $classes[count( $classes ) - 1] . $class_code;
}

// make traits to classes
$regexp = '#trait([\s]+[\S]+[\s]*){#';
$replace = 'class$1{';
$source = preg_replace( $regexp, $replace, $source );

// use traits by extending them (classes that not extending a class)
$regexp = '#class([\s]+[\S]+[\s]*){[\s]+use([^;]+);#';
$replace = 'class$1 extends $2 {';
$source = preg_replace( $regexp, $replace, $source );

// use traits by extending them (classes that already extending a class)
$regexp = '#class([\s]+[\S]+[\s]+extends[\s]+[\S]+[\s]*){[\s]+use([^;]+);#';
$replace = 'class$1, $2 {';
$source = preg_replace( $regexp, $replace, $source );

// Output
echo $source;
