<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text with right padding.
 *
 * Pads the text to the specified length with the given character using {@see str_pad()}.
 *
 * Construction forms:
 *
 * - `new RightPadded(Text, int, string)` — wrap an existing {@see Text} value.
 * - `RightPadded::ofText(Text, int, string)` — named-constructor alias of the primary ctor.
 * - `RightPadded::ofString(string, int, string)` — shortcut that wraps a native
 *   string in {@see TextOf::str()} before padding.
 *
 * Example:
 *     $text = RightPadded::ofText(TextOf::str('foo'), 6, '.');
 *     echo $text->value(); // 'foo...'
 */
final readonly class RightPadded extends TextEnvelope
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
                new FuncOf(static fn(string $s): string => str_pad($s, $length, $padding)),
            ),
        );
    }

    /**
     * Pads a {@see Text} on the right to a desired length.
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
     * Pads a native string on the right to a desired length.
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
