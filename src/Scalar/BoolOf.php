<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Text\Text;

/**
 * Boolean parsed from a {@see Text} or native string.
 *
 * Named constructors dispatch on the source family:
 *
 * - `BoolOf::text(Text)` — parse a {@see Text} value.
 * - `BoolOf::str(string)` — parse a native string directly.
 *
 * Both forms delegate parsing to {@see filter_var()} with
 * `FILTER_VALIDATE_BOOLEAN`, which accepts the common truthy/falsy
 * spellings: `true`, `false`, `yes`, `no`, `on`, `off`, `1`, `0`
 * (case-insensitive, surrounding whitespace is tolerated). Any other
 * input is treated as `false`.
 *
 * Each form re-evaluates the source on every {@see Scalar::value()}
 * call — wrap in {@see Sticky} to memoize.
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
 *     $enabled = BoolOf::str('yes');
 *     echo $enabled->value() ? 'on' : 'off'; // 'on'
 *
 *     $padded = BoolOf::text(TextOf::str(' true '));
 *     echo $padded->value() ? 'on' : 'off'; // 'on' — surrounding whitespace tolerated
 *
 *     $disabled = BoolOf::str('garbage');
 *     echo $disabled->value() ? 'on' : 'off'; // 'off'
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class BoolOf extends ScalarEnvelope
{
    /**
     * Sole point of construction; reached through the named factories.
     *
     * @param Scalar<bool> $origin
     */
    private function __construct(Scalar $origin)
    {
        parent::__construct($origin);
    }

    /**
     * Wraps a {@see Text} value as a parsed boolean.
     *
     * @param Text $text Source text
     * @psalm-api
     */
    public static function text(Text $text): self
    {
        return new self(
            new ScalarOf(
                static fn(): bool => filter_var(
                    $text->value(),
                    FILTER_VALIDATE_BOOLEAN,
                ),
            ),
        );
    }

    /**
     * Wraps a native string as a parsed boolean.
     *
     * @param string $value Source string
     * @psalm-api
     */
    public static function str(string $value): self
    {
        return new self(
            new ScalarOf(
                static fn(): bool => filter_var(
                    $value,
                    FILTER_VALIDATE_BOOLEAN,
                ),
            ),
        );
    }
}
