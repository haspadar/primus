<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text in lowercase.
 *
 * Converts the given text to lowercase using multibyte support.
 *
 * Example:
 *     $text = new Lowered(new TextOf('CAFÉ & TÜRKİYE'));
 *     echo $text->value(); // 'café & türkiye'
 *
 * @since 0.1
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
            new TextOf(mb_strtolower($origin->value(), 'UTF-8')),
        );
    }
}
