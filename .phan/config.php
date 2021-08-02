<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php';

$cfg['directory_list'] = [
	'src',
	'vendor',
	'tests'
];

// PHPUnit 8.5 doesn't have assertMatchesRegularExpression, but 9.5 does. Joy.
$cfg['suppress_issue_types'][] = 'PhanUndeclaredMethod';

$cfg['exclude_analysis_directory_list'][] = 'vendor';

$cfg['exclude_file_list'][] = 'tests/phplint/autoload.php';

return $cfg;
