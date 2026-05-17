<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarOf;

/**
 * Text joined from multiple Text parts with a separator.
 *
 * Example:
 *     $text = new Joined(', ', [TextOf::str('a'), TextOf::str('b'), TextOf::str('c')]);
 *     echo $text->value(); // 'a, b, c'
 */
final readonly class Joined extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param string $separator The glue inserted between parts.
     * @param list<Text> $parts The texts to join.
     */
    public function __construct(string $separator, array $parts)
    {
        parent::__construct(
            TextOf::scalar(
                new ScalarOf(static fn(): string => implode(
                    $separator,
                    array_map(
                        static fn(Text $t): string => $t->value(),
                        $parts,
                    ),
                )),
            ),
        );
    }
}
