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
 * Example:
 *     $text = new LeftPadded(new TextOf('foo'), 6, '.');
 *     echo $text->value(); // '...foo'
 *
 * @since 0.2
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
}
