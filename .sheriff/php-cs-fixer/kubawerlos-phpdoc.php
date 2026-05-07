<?php

declare(strict_types=1);

// kubawerlos/php-cs-fixer-custom-fixers: PHPDoc rules
return [
    PhpCsFixerCustomFixers\Fixer\PhpdocNoIncorrectVarAnnotationFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocParamTypeFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocPropertySortedFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocSelfAccessorFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocTypeListFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\PhpdocTypesTrimFixer::name() => true,
];
