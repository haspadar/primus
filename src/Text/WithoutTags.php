<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text without HTML tags.
 *
 * Strips all HTML tags from the origin text using {@see strip_tags()}.
 *
 * Construction forms:
 *
 * - `new WithoutTags(Text)` — wrap an existing {@see Text} value.
 * - `WithoutTags::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `WithoutTags::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before stripping tags.
 *
 * Example:
 *     $text = WithoutTags::ofText(TextOf::str('<b>John & "Jane"</b>'));
 *     echo $text->value(); // 'John & "Jane"'
 */
final readonly class WithoutTags extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to strip HTML tags from.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(strip_tags(...)),
            ),
        );
    }

    /**
     * Strips HTML tags from a {@see Text}.
     *
     * @param Text $source The text to strip HTML tags from.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Strips HTML tags from a native string.
     *
     * @param string $value The string to strip HTML tags from.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
