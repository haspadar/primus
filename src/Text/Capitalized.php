<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text with the first character capitalized.
 *
 * Converts only the first character to uppercase
 * and leaves the rest of the text unchanged.
 *
 * Construction forms:
 *
 * - `new Capitalized(Text)` — wrap an existing {@see Text} value.
 * - `Capitalized::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before capitalising.
 *
 * Example:
 *     $text = new Capitalized(TextOf::str('hello'));
 *     echo $text->value(); // 'Hello'
 *
 *     $text = Capitalized::ofString('hello');
 *     echo $text->value(); // 'Hello'
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

    /**
     * Capitalises a native string.
     *
     * @param string $value The string to capitalise.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
