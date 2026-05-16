<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text with its characters in reverse order.
 *
 * Reverses by Unicode codepoints via {@see mb_str_split()}, so multibyte
 * characters are preserved as whole units instead of being split into bytes.
 *
 * Note: reversal is by codepoint, not by grapheme cluster. Combining marks
 * (NFD form, e.g. "e" + U+0301) are reordered separately from their base
 * character. Pre-normalize to NFC if grapheme stability is required.
 *
 * Example:
 *     $text = new Reversed(TextOf::ofString('café'));
 *     echo $text->value(); // 'éfac'
 */
final readonly class Reversed extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to reverse.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(
                    static fn(string $s): string => implode('', array_reverse(mb_str_split($s, 1, 'UTF-8'))),
                ),
            ),
        );
    }
}
