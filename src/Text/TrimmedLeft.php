<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Func\FuncOf;

/**
 * Text with whitespace removed from the left side.
 *
 * Construction forms:
 *
 * - `new TrimmedLeft(Text)` — wrap an existing {@see Text} value.
 * - `TrimmedLeft::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `TrimmedLeft::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before trimming.
 *
 * Example:
 *     $text = TrimmedLeft::ofText(TextOf::str(" hello "));
 *     echo $text->value(); // 'hello '
 */
final readonly class TrimmedLeft extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the left.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => preg_replace('/^\s+/u', '', $s)
                    ?? throw new InvalidArgumentException('Malformed UTF-8 input')),
            ),
        );
    }

    /**
     * Removes leading whitespace from a {@see Text}.
     *
     * @param Text $source The text to trim on the left.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Removes leading whitespace from a native string.
     *
     * @param string $value The string to trim on the left.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
