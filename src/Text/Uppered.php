<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text in uppercase.
 *
 * Converts the given text to uppercase using multibyte support.
 *
 * Construction forms:
 *
 * - `new Uppered(Text)` — wrap an existing {@see Text} value.
 * - `Uppered::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `Uppered::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before uppercasing.
 *
 * Example:
 *     $text = Uppered::ofText(TextOf::str('touché résumé'));
 *     echo $text->value(); // 'TOUCHÉ RÉSUMÉ'
 *
 *     $text = Uppered::ofString('touché résumé');
 *     echo $text->value(); // 'TOUCHÉ RÉSUMÉ'
 */
final readonly class Uppered extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to uppercase.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => mb_strtoupper($s, 'UTF-8')),
            ),
        );
    }

    /**
     * Uppercases a {@see Text}.
     *
     * @param Text $source The text to uppercase.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Uppercases a native string.
     *
     * @param string $value The string to uppercase.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
