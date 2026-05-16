<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Substring of a {@see Text}.
 *
 * Uses {@see mb_substr()} to return a portion of the text.
 * Equivalent to {@see mb_substr($text, $start, PHP_INT_MAX, 'UTF-8')}.
 *
 * Example:
 *     $text = new Sub(TextOf::ofString('hello world'), 0, 5);
 *     echo $text->value(); // 'hello'
 */
final readonly class Sub extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $text The text to extract from.
     * @param int $start The start position in characters.
     * @param int $length The maximum number of characters to extract.
     */
    public function __construct(Text $text, int $start, int $length = PHP_INT_MAX)
    {
        parent::__construct(
            new Mapped(
                $text,
                new FuncOf(static fn(string $s): string => mb_substr($s, $start, $length, 'UTF-8')),
            ),
        );
    }
}
