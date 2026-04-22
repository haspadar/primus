<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text with right padding.
 *
 * Pads the text to the specified length with the given character using {@see str_pad()}.
 *
 * Example:
 *     $text = new RightPadded(new TextOf('foo'), 6, '.');
 *     echo $text->value(); // 'foo...'
 *
 * @since 0.1
 */
final readonly class RightPadded extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to pad.
     * @param int $length The desired total length after padding.
     * @param string $padChar The character to use for padding.
     */
    public function __construct(
        Text $origin,
        int $length,
        string $padChar
    ) {
        parent::__construct(
            new TextOf(
                str_pad(
                    $origin->value(),
                    $length,
                    $padChar
                )
            )
        );
    }
}
