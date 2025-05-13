<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

$cfg['directory_list'][] = 'tests';
$cfg['directory_list'][] = '.phan/stubs';
$cfg['exclude_file_list'][] = 'tests/phplint/autoload.php';

return $cfg;
