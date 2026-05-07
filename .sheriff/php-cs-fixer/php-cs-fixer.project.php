<?php

declare(strict_types=1);

use PhpCsFixer\Finder;

/** @var PhpCsFixer\Config $rules */
$rules = require __DIR__ . '/php-cs-fixer.php';

$rules->setFinder(
    Finder::create()
        ->in([__DIR__ . '/../..'])
        ->exclude(['vendor','tests','.git']),
)->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');

return $rules;
