<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text in uppercase.
 *
 * Converts the given text to uppercase using multibyte support.
 *
 * Example:
 *     $text = new Uppered(TextOf::ofString('touché résumé'));
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
}
