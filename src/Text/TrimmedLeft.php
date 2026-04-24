<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text with whitespace removed from the left side.
 *
 * Example:
 *     $text = new TrimmedLeft(new TextOf("   hello "));
 *     echo $text->value(); // 'hello '
 *
 * @since 0.2
 */
final readonly class TrimmedLeft extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the left.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(
                (string) preg_replace('/^\s+/u', '', $origin->value()),
            ),
        );
    }
}
