<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text joined from multiple Text parts with a separator.
 *
 * Example:
 *     $text = new Joined(', ', [new TextOf('a'), new TextOf('b'), new TextOf('c')]);
 *     echo $text->value(); // 'a, b, c'
 *
 * @since 0.2
 */
final readonly class Joined extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param string $separator The glue inserted between parts.
     * @param iterable<Text> $parts The texts to join.
     */
    public function __construct(string $separator, iterable $parts)
    {
        parent::__construct(
            new TextOf(
                implode(
                    $separator,
                    array_map(
                        static fn(Text $t): string => $t->value(),
                        is_array($parts) ? $parts : iterator_to_array($parts, false),
                    ),
                ),
            ),
        );
    }
}
