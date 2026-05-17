<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarOf;

/**
 * Abbreviated {@see Text}.
 *
 * Truncates the origin text to a maximum length and appends an ellipsis.
 * If the text length does not exceed the limit, it is returned unchanged.
 *
 * Example:
 *     $text = new Abbreviated(TextOf::str('Hello, world!'), 8);
 *     echo $text->value(); // 'Hello, w…'
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
        parent::__construct(
            TextOf::scalar(
                new ScalarOf(
                    static function () use ($origin, $limit): string {
                        if ($limit <= 0) {
                            return '';
                        }

                        if (mb_strlen($origin->value(), 'UTF-8') <= $limit) {
                            return $origin->value();
                        }

                        return sprintf('%s…', mb_substr($origin->value(), 0, $limit - 1, 'UTF-8'));
                    },
                ),
            ),
        );
    }
}
