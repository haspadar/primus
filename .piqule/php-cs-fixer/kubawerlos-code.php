<?php

declare(strict_types=1);

// kubawerlos/php-cs-fixer-custom-fixers: code quality rules
return [
    PhpCsFixerCustomFixers\Fixer\ClassConstantUsageFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\CommentSurroundedBySpacesFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\ForeachUseValueFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\FunctionParameterSeparationFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\MultilineCommentOpeningClosingAloneFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoReferenceInFunctionDefinitionFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoUselessDirnameCallFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoUselessParenthesisFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\NoUselessStrlenFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\SingleSpaceBeforeStatementFixer::name() => true,
    PhpCsFixerCustomFixers\Fixer\TrimKeyFixer::name() => true,
];
