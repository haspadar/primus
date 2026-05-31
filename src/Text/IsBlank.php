<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks whether the text is empty or contains only Unicode whitespace.
 *
 * Treats both ASCII whitespace and Unicode whitespace (including
 * non-breaking spaces, line/paragraph separators, etc.) as blank.
 *
 * Construction forms:
 *
 * - `new IsBlank(Text)` — wrap a {@see Text} to check.
 * - `IsBlank::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `IsBlank::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before checking.
 *
 * Example:
 *     $blank = IsBlank::ofString(" \t\n");
 *     echo $blank->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class IsBlank extends ScalarEnvelope
{
    private const string BLANK_PATTERN = '/(*UCP)^\s*$/u';

    /**
     * Ctor.
     *
     * @param Text $text The text to check.
     */
    public function __construct(Text $text)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => preg_match(self::BLANK_PATTERN, $text->value()) === 1,
            ),
        );
    }

    /**
     * Tells whether a {@see Text} is empty or only whitespace.
     *
     * @param Text $source The text to check.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Tells whether a native string is empty or only whitespace.
     *
     * @param string $value The string to check.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
