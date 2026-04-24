<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text with the first character capitalized.
 *
 * Converts only the first character to uppercase
 * and leaves the rest of the text unchanged.
 *
 * Example:
 *     $text = new Capitalized(new TextOf('hello'));
 *     echo $text->value(); // 'Hello'
 *
 * @since 0.2
 */
final readonly class Capitalized extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to capitalize.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Joined('', [
                new Uppered(new Sub($origin, 0, 1)),
                new Sub($origin, 1),
            ]),
        );
    }
}
