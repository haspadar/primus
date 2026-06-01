<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;
use Primus\Scalar\Scalar;

/**
 * Text split by a delimiter into parts.
 *
 * Produces an iterable of {@see Text} segments separated by the given delimiter.
 *
 * Construction forms:
 *
 * - `new Split(string, Text)` — wrap a delimiter and a {@see Text} to split.
 * - `Split::ofText(string, Text)` — named-constructor alias of the primary ctor.
 * - `Split::ofString(string, string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before splitting.
 *
 * Example:
 *     $parts = Split::ofString(',', 'a,b,c');
 *     foreach ($parts->value() as $text) {
 *         echo $text->value(); // a, b, c
 *     }
 *
 * @implements Scalar<iterable<Text>>
 */
final readonly class Split implements Scalar
{
    /**
     * Ctor.
     *
     * @param non-empty-string $delimiter The delimiter used to split the text.
     * @param Text $origin The text to split.
     */
    public function __construct(private string $delimiter, private Text $origin) {}

    /**
     * Splits a {@see Text} by a delimiter into parts.
     *
     * @param non-empty-string $glue The delimiter used to split the text.
     * @param Text $source The text to split.
     * @psalm-api
     */
    public static function ofText(string $glue, Text $source): self
    {
        return new self($glue, $source);
    }

    /**
     * Splits a native string by a delimiter into parts.
     *
     * @param non-empty-string $glue The delimiter used to split the string.
     * @param string $value The string to split.
     * @psalm-api
     */
    public static function ofString(string $glue, string $value): self
    {
        return new self($glue, TextOf::str($value));
    }

    #[Override]
    public function value(): iterable
    {
        foreach (explode($this->delimiter, $this->origin->value()) as $part) {
            yield TextOf::str($part);
        }
    }
}
