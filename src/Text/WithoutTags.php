<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * Text without HTML tags.
 *
 * Strips all HTML tags from the origin text using {@see strip_tags()}.
 *
 * Example:
 *     $text = new WithoutTags(new TextOf('<b>John & "Jane"</b>'));
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
        parent::__construct($origin);
    }

    #[Override]
    public function value(): string
    {
        return strip_tags($this->origin->value());
    }
}
