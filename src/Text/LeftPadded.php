<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text with left padding.
 *
 * Pads the text on the left to the specified length
 * with the given character using {@see str_pad()}.
 *
 * Construction forms:
 *
 * - `new LeftPadded(Text, int, string)` — wrap an existing {@see Text} value.
 * - `LeftPadded::ofText(Text, int, string)` — named-constructor alias of the primary ctor.
 * - `LeftPadded::ofString(string, int, string)` — shortcut that wraps a native
 *   string in {@see TextOf::str()} before padding.
 *
 * Example:
 *     $text = LeftPadded::ofText(TextOf::str('foo'), 6, '.');
 *     echo $text->value(); // '...foo'
 */
final readonly class LeftPadded extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to pad.
     * @param int $length The desired total length after padding.
     * @param string $padding The character to use for padding.
     */
    public function __construct(Text $origin, int $length, string $padding)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => str_pad($s, $length, $padding, STR_PAD_LEFT)),
            ),
        );
    }

    /**
     * Pads a {@see Text} on the left to a desired length.
     *
     * @param Text $source The text to pad.
     * @param int $length The desired total length after padding.
     * @param string $padding The character to use for padding.
     * @psalm-api
     */
    public static function ofText(Text $source, int $length, string $padding): self
    {
        return new self($source, $length, $padding);
    }

    /**
     * Pads a native string on the left to a desired length.
     *
     * @param string $value The string to pad.
     * @param int $length The desired total length after padding.
     * @param string $padding The character to use for padding.
     * @psalm-api
     */
    public static function ofString(string $value, int $length, string $padding): self
    {
        return new self(TextOf::str($value), $length, $padding);
    }
}
