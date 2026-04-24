<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text repeated multiple times.
 *
 * Example:
 *     $text = new Repeated(new TextOf('xo'), 3);
 *     echo $text->value(); // 'xoxoxo'
 *
 * @since 0.2
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
            new TextOf(
                str_repeat($origin->value(), max(0, $count)),
            ),
        );
    }
}
