<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text repeated multiple times.
 *
 * Example:
 *     $text = new Repeated(TextOf::str('xo'), 3);
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
}
