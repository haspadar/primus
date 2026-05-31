<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Func\FuncOf;

/**
 * Text with whitespace removed from the right side.
 *
 * Construction forms:
 *
 * - `new TrimmedRight(Text)` — wrap an existing {@see Text} value.
 * - `TrimmedRight::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `TrimmedRight::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before trimming.
 *
 * Example:
 *     $text = TrimmedRight::ofText(TextOf::str(" hello "));
 *     echo $text->value(); // ' hello'
 */
final readonly class TrimmedRight extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the right.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => preg_replace('/\s+$/u', '', $s)
                    ?? throw new InvalidArgumentException('Malformed UTF-8 input')),
            ),
        );
    }

    /**
     * Removes trailing whitespace from a {@see Text}.
     *
     * @param Text $source The text to trim on the right.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Removes trailing whitespace from a native string.
     *
     * @param string $value The string to trim on the right.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
