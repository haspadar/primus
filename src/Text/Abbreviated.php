<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Abbreviated {@see Text}.
 *
 * Truncates the origin text to a maximum length and appends an ellipsis.
 * If the text length does not exceed the limit, it is returned unchanged.
 *
 * Example:
 *     $text = new Abbreviated(new TextOf('Hello, world!'), 8);
 *     echo $text->value(); // 'Hello, w…'
 *
 * @since 0.1
 */
final readonly class Abbreviated extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to abbreviate.
     * @param int $limit The maximum length of the result.
     */
    public function __construct(Text $origin, int $limit = 50)
    {
        /** @phpstan-ignore haspadar.constructorInit */
        if ($limit <= 0) {
            parent::__construct(new TextOf(''));

            return;
        }

        /** @phpstan-ignore haspadar.constructorInit */
        $length = new LengthOfText($origin);
        /** @phpstan-ignore haspadar.constructorInit */
        if ($length->value() <= $limit) {
            parent::__construct($origin);

            return;
        }

        /** @phpstan-ignore haspadar.constructorInit */
        $truncated = sprintf('%s…', (new Sub($origin, 0, $limit - 1))->value());
        parent::__construct(new TextOf($truncated));
    }
}
