<?php

/*
 * PHPLint fake entry point
 */
/*.

require_module 'array';
require_module 'core';
require_module 'file';
require_module 'pcre';
require_module 'spl';

.*/

function __autoload( /*. string .*/ $className ) {
	/*. pragma 'autoload' 'schema1' '../..' '/' '.php'; .*/
	require_once '../../' .
		str_replace( '\\', '/', $className ) . '.php';
}

