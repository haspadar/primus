<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text repeated multiple times.
 *
 * Construction forms:
 *
 * - `new Repeated(Text, int)` — wrap an existing {@see Text} value.
 * - `Repeated::ofString(string, int)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before repeating.
 *
 * Example:
 *     $text = new Repeated(TextOf::str('xo'), 3);
 *     echo $text->value(); // 'xoxoxo'
 *
 *     $text = Repeated::ofString('xo', 3);
 *     echo $text->value(); // 'xoxoxo'
 */
final readonly class Repeated extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to repeat.
     * @param int $count The number of repetitions.
     */
    public function __construct(Text $origin, int $count)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => str_repeat($s, max(0, $count))),
            ),
        );
    }

    /**
     * Repeats a native string.
     *
     * @param string $value The string to repeat.
     * @param int $count The number of repetitions.
     * @psalm-api
     */
    public static function ofString(string $value, int $count): self
    {
        return new self(TextOf::str($value), $count);
    }
}
