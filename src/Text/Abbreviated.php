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
 * Construction forms:
 *
 * - `new Abbreviated(Text, int = 50)` — wrap an existing {@see Text} value.
 * - `Abbreviated::ofText(Text, int = 50)` — named-constructor alias of the primary ctor.
 * - `Abbreviated::ofString(string, int = 50)` — shortcut that wraps a native
 *   string in {@see TextOf::str()} before abbreviating.
 *
 * Example:
 *     $text = Abbreviated::ofText(TextOf::str('Hello, world!'), 8);
 *     echo $text->value(); // 'Hello, w…'
 */
final readonly class Abbreviated extends TextEnvelope
{
    private const int DEFAULT_LIMIT = 50;

    /**
     * Ctor.
     *
     * @param Text $origin The text to abbreviate.
     * @param int $limit The maximum length of the result.
     */
    public function __construct(Text $origin, int $limit = self::DEFAULT_LIMIT)
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

    /**
     * Abbreviates a {@see Text} to the given length.
     *
     * @param Text $source The text to abbreviate.
     * @param int $limit The maximum length of the result.
     * @psalm-api
     */
    public static function ofText(Text $source, int $limit = self::DEFAULT_LIMIT): self
    {
        return new self($source, $limit);
    }

    /**
     * Abbreviates a native string to the given length.
     *
     * @param string $value The string to abbreviate.
     * @param int $limit The maximum length of the result.
     * @psalm-api
     */
    public static function ofString(string $value, int $limit = self::DEFAULT_LIMIT): self
    {
        return new self(TextOf::str($value), $limit);
    }
}
