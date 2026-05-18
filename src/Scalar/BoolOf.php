<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Text\Text;

/**
 * Boolean parsed from a {@see Text} value.
 *
 * Delegates parsing to {@see filter_var()} with `FILTER_VALIDATE_BOOLEAN`,
 * which accepts the common truthy/falsy spellings: `true`, `false`, `yes`,
 * `no`, `on`, `off`, `1`, `0` (case-insensitive, surrounding whitespace is
 * tolerated). Any other input is treated as `false`.
 *
 * The accepted vocabulary is wider than Cactoos `BoolOf` (which only
 * matches `Boolean.valueOf` semantics — `true` literal vs everything else) —
 * the extra spellings reflect typical PHP config and env-var conventions.
 *
 * Useful for reading boolean flags from configuration files or environment
 * variables and composing the result with other {@see Scalar} primitives
 * (`Ternary`, `And_`, `Or_`).
 *
 * Example:
 *     $enabled = new BoolOf(TextOf::str('yes'));
 *     echo $enabled->value() ? 'on' : 'off'; // 'on'
 *
 *     $padded = new BoolOf(TextOf::str(' true '));
 *     echo $padded->value() ? 'on' : 'off'; // 'on' — surrounding whitespace tolerated
 *
 *     $disabled = new BoolOf(TextOf::str('garbage'));
 *     echo $disabled->value() ? 'on' : 'off'; // 'off'
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class BoolOf extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to parse.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => filter_var(
                    $origin->value(),
                    FILTER_VALIDATE_BOOLEAN,
                ),
            ),
        );
    }
}
