<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarOf;
use Primus\Scalar\Sticky;

/**
 * Randomly generated {@see Text}.
 *
 * Creates a text of a given length composed of characters
 * from the specified alphabet.
 *
 * Construction forms:
 *
 * - `new RandomText(int, string = ...)` — generate a random text of given length.
 * - `RandomText::ofLength(int, string = ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $text = RandomText::ofLength(8);
 *     echo $text->value(); // e.g. 'aZ8mKp2Q'
 */
final readonly class RandomText extends TextEnvelope
{
    private const string DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * Ctor.
     *
     * @param int $length The length of the generated text.
     * @param string $alphabet The characters to pick from.
     */
    public function __construct(int $length, string $alphabet = self::DEFAULT_ALPHABET)
    {
        parent::__construct(
            TextOf::scalar(
                new Sticky(
                    new ScalarOf(
                        static function () use ($length, $alphabet): string {
                            $source = $alphabet !== ''
                                ? $alphabet
                                : 'a';
                            $size = mb_strlen($source, 'UTF-8');
                            $chars = [];

                            for ($i = 0; $i < max(0, $length); $i++) {
                                $chars[] = mb_substr($source, random_int(0, $size - 1), 1, 'UTF-8');
                            }

                            return implode('', $chars);
                        },
                    ),
                ),
            ),
        );
    }

    /**
     * Builds a random text of the given length from the alphabet.
     *
     * @param int $length The length of the generated text.
     * @param string $alphabet The characters to pick from.
     * @psalm-api
     */
    public static function ofLength(int $length, string $alphabet = self::DEFAULT_ALPHABET): self
    {
        return new self($length, $alphabet);
    }
}
