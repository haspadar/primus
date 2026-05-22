<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text in lowercase.
 *
 * Converts the given text to lowercase using multibyte support.
 *
 * Construction forms:
 *
 * - `new Lowered(Text)` — wrap an existing {@see Text} value.
 * - `Lowered::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before lowercasing.
 *
 * Example:
 *     $text = new Lowered(TextOf::str('CAFÉ & TÜRKİYE'));
 *     echo $text->value(); // 'café & türkiye'
 *
 *     $text = Lowered::ofString('CAFÉ & TÜRKİYE');
 *     echo $text->value(); // 'café & türkiye'
 */
final readonly class Lowered extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to lowercase.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => mb_strtolower($s, 'UTF-8')),
            ),
        );
    }

    /**
     * Lowercases a native string.
     *
     * @param string $value The string to lowercase.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
