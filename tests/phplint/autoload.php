<?php

/*.

require_module 'array';
require_module 'core';
require_module 'file';
require_module 'pcre';
require_module 'spl';

.*/

/**
 * PHPLint fake entry point
 * @param string $className
 */
spl_autoload_register( static function ( /*. string .*/ $className ) {
	/*. pragma 'autoload' 'schema1' '../..' '/' '.php'; .*/
	require_once '../../' .
		str_replace( '\\', '/', $className ) . '.php';
} );
