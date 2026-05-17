<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text without HTML tags.
 *
 * Strips all HTML tags from the origin text using {@see strip_tags()}.
 *
 * Example:
 *     $text = new WithoutTags(TextOf::str('<b>John & "Jane"</b>'));
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
}
