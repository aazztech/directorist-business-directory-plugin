<?php
use Rector\Config\RectorConfig;

return RectorConfig::configure()
	->withPaths([
		__DIR__ . '/includes',
	])
	->withRootFiles()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
		typeDeclarations: true,
		codingStyle: true,
    )
	->withPhpSets(php70: true);