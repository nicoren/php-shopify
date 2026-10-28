<?php

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/lib', __DIR__ . '/tests']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS' => true,
        '@PHP82Migration' => true,
        'no_unused_imports' => true,
    ])
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setFinder($finder);
