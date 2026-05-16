<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text in lowercase.
 *
 * Converts the given text to lowercase using multibyte support.
 *
 * Example:
 *     $text = new Lowered(TextOf::ofString('CAFÉ & TÜRKİYE'));
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
}
