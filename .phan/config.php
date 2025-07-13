<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

$cfg['directory_list'][] = 'tests';
$cfg['directory_list'][] = '.phan/stubs';
$cfg['exclude_file_list'][] = 'tests/phplint/autoload.php';
$cfg['exception_classes_with_optional_throws_phpdoc'] = [
	...$cfg['exception_classes_with_optional_throws_phpdoc'],
	\Wikimedia\RemexHtml\Serializer\SerializerError::class,
	\Wikimedia\RemexHtml\Tokenizer\TokenizerError::class,
	\Wikimedia\RemexHtml\TreeBuilder\TreeBuilderError::class,
];

return $cfg;
