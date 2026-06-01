<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks if text is falsy in a boolean context.
 *
 * Returns true for the strings PHP treats as false in `if ($str)`,
 * namely '' and '0'. Any other string yields false.
 *
 * Construction forms:
 *
 * - `new IsEmpty(Text)` — wrap a {@see Text} to check.
 * - `IsEmpty::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `IsEmpty::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before checking.
 *
 * Example:
 *     $empty = IsEmpty::ofString('0');
 *     echo $empty->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class IsEmpty extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $text The text to check.
     */
    public function __construct(Text $text)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => in_array($text->value(), ['', '0'], true),
            ),
        );
    }

    /**
     * Tells whether a {@see Text} is falsy.
     *
     * @param Text $source The text to check.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Tells whether a native string is falsy.
     *
     * @param string $value The string to check.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
