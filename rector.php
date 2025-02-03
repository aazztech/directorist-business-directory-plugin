<?php
use Rector\Config\RectorConfig;

return RectorConfig::configure()
	->withPaths([
		__DIR__ . '/includes',
		__DIR__ . '/views',
		__DIR__ . '/templates',
		__DIR__ . '/blocks'
	])
	->withRootFiles()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
		typeDeclarations: true,
		codingStyle: true,
    )
	->withPhpSets(php70: true);