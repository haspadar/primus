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
 * Construction forms:
 *
 * - `new Reversed(Text)` — wrap an existing {@see Text} value.
 * - `Reversed::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `Reversed::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before reversing.
 *
 * Example:
 *     $text = Reversed::ofText(TextOf::str('café'));
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

    /**
     * Reverses character order in a {@see Text}.
     *
     * @param Text $source The text to reverse.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Reverses character order in a native string.
     *
     * @param string $value The string to reverse.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
