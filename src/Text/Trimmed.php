<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text without leading or trailing whitespace.
 *
 * Applies {@see trim()} to the original text.
 *
 * Construction forms:
 *
 * - `new Trimmed(Text)` — wrap an existing {@see Text} value.
 * - `Trimmed::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `Trimmed::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before trimming.
 *
 * Example:
 *     $text = Trimmed::ofText(TextOf::str(' hello '));
 *     echo $text->value(); // 'hello'
 *
 *     $text = Trimmed::ofString(' hello ');
 *     echo $text->value(); // 'hello'
 */
final readonly class Trimmed extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(trim(...)),
            ),
        );
    }

    /**
     * Trims leading and trailing whitespace from a {@see Text}.
     *
     * @param Text $source The text to trim.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Trims leading and trailing whitespace from a native string.
     *
     * @param string $value The string to trim.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
