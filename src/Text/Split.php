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
 * Example:
 *     $parts = new Split(',', TextOf::str('a,b,c'));
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

    #[Override]
    public function value(): iterable
    {
        foreach (explode($this->delimiter, $this->origin->value()) as $part) {
            yield TextOf::str($part);
        }
    }
}
