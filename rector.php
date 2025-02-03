<?php
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return RectorConfig::configure()
	->withPaths([
		// __DIR__ . '/config.php',
		// __DIR__ . '/directorist-base.php',
		__DIR__ . '/includes',
	])
	->withRootFiles()
    // register single rule
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class
    ])
    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
		typeDeclarations: true,
		codingStyle: true,
    )
	->withPhpSets(php70: true);