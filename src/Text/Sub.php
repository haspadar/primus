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
 * Construction forms:
 *
 * - `new Sub(Text, int, int = PHP_INT_MAX)` — wrap a {@see Text} with offsets.
 * - `Sub::ofText(Text, int, int = PHP_INT_MAX)` — named-constructor alias of the primary ctor.
 * - `Sub::ofString(string, int, int = PHP_INT_MAX)` — shortcut that wraps a
 *   native string in {@see TextOf::str()} before slicing.
 *
 * Example:
 *     $text = Sub::ofString('hello world', 0, 5);
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

    /**
     * Extracts a substring from a {@see Text}.
     *
     * @param Text $source The text to extract from.
     * @param int $start The start position in characters.
     * @param int $length The maximum number of characters to extract.
     * @psalm-api
     */
    public static function ofText(Text $source, int $start, int $length = PHP_INT_MAX): self
    {
        return new self($source, $start, $length);
    }

    /**
     * Extracts a substring from a native string.
     *
     * @param string $value The string to extract from.
     * @param int $start The start position in characters.
     * @param int $length The maximum number of characters to extract.
     * @psalm-api
     */
    public static function ofString(string $value, int $start, int $length = PHP_INT_MAX): self
    {
        return new self(TextOf::str($value), $start, $length);
    }
}
