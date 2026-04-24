<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Scalar\ScalarOf;

/**
 * Text with whitespace removed from the right side.
 *
 * Example:
 *     $text = new TrimmedRight(new TextOf(" hello "));
 *     echo $text->value(); // ' hello'
 *
 * @since 0.2
 */
final readonly class TrimmedRight extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the right.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOfScalar(
                new ScalarOf(
                    static fn(): string => preg_replace('/\s+$/u', '', $origin->value())
                        ?? throw new InvalidArgumentException('Malformed UTF-8 input'),
                ),
            ),
        );
    }
}
