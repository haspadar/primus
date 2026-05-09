<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * Text in uppercase.
 *
 * Converts the given text to uppercase using multibyte support.
 *
 * Example:
 *     $text = new Uppered(new TextOf('touché résumé'));
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
        parent::__construct($origin);
    }

    #[Override]
    public function value(): string
    {
        return mb_strtoupper($this->origin->value(), 'UTF-8');
    }
}
