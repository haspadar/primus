<?php

declare(strict_types=1);

/**
 * This ruleset is meant to be reused across projects in two ways:
 *
 * 1) Directly, by running `php-cs-fixer fix --config=configs/php-cs-fixer.php`
 *    and passing the target paths via CLI arguments.
 *
 * 2) Imported from a project's root `.php-cs-fixer.php`, where the project
 *    defines its own Finder / path configuration.
 *
 * Only the rule definitions are shared across projects; path and Finder
 * configuration belong to the consuming project.
 */

$customFixers = new PhpCsFixerCustomFixers\Fixers();

return (new PhpCsFixer\Config())
    ->registerCustomFixers($customFixers)
    ->setRiskyAllowed(true)
    ->setRules(array_merge(
        require __DIR__ . '/kubawerlos-code.php',
        require __DIR__ . '/kubawerlos-phpdoc.php',
    [

        '@PER-CS2.0' => true,
        '@PHP8x3Migration' => true,

        // Arrays
        'array_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],

        // Imports
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,
        'no_leading_import_slash' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],

        // Strict types
        'declare_strict_types' => true,
        'declare_equal_normalize' => ['space' => 'none'],

        // Final & visibility
        'final_class' => true,
        'final_internal_class' => true,

        // Types
        'native_type_declaration_casing' => true,

        // Formatting
        'blank_line_before_statement' => ['statements' => ['return', 'throw', 'try']],
        'class_attributes_separation' => [
            'elements' => ['method' => 'one', 'property' => 'one'],
        ],
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'no_blank_lines_after_class_opening' => true,
        'no_extra_blank_lines' => ['tokens' => ['extra', 'throw', 'use']],
        'no_trailing_comma_in_singleline' => true,
        'no_whitespace_in_blank_line' => true,

        // PHPDoc
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_indent' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,

        // Clean code
        'strict_comparison' => true,
        'strict_param' => true,

        // Casting
        'cast_spaces' => ['space' => 'single'],
        'lowercase_cast' => true,

        // Control structures
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,

        // Operators
        'binary_operator_spaces' => ['default' => 'single_space'],
        'concat_space' => ['spacing' => 'one'],
        'unary_operator_spaces' => true,
        'not_operator_with_successor_space' => false,

        // Misc
        'encoding' => true,
        'full_opening_tag' => true,
        'single_quote' => true,
        'ternary_operator_spaces' => true,

        // PHP 8.4 compatibility: keep parentheses around `new` expressions
        // so tools based on pdepend (phpmd) can still parse the code
        'new_expression_parentheses' => ['use_parentheses' => true],
    ]))
    ->setUnsupportedPhpVersionAllowed(true);
