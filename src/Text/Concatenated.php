<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text concatenated from multiple {@see Text} parts without a separator.
 *
 * Equivalent to {@see Joined} with an empty separator. Parts are concatenated
 * in argument order.
 *
 * Example:
 *     $text = new Concatenated(
 *         TextOf::ofString('hello, '),
 *         TextOf::ofString('world'),
 *     );
 *     echo $text->value(); // 'hello, world'
 */
final readonly class Concatenated extends TextEnvelope
{
    private const string SEPARATOR = '';

    /**
     * Ctor.
     *
     * @param Text ...$parts The texts to concatenate.
     */
    public function __construct(Text ...$parts)
    {
        parent::__construct(new Joined(self::SEPARATOR, array_values($parts)));
    }
}
