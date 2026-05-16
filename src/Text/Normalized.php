<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Scalar\ScalarOf;

/**
 * Text with normalized whitespace.
 *
 * Replaces multiple spaces, tabs, and newlines
 * with a single space and trims leading/trailing whitespace.
 *
 * Example:
 *     $text = new Normalized(TextOf::ofString(" Hello \n\t world "));
 *     echo $text->value(); // 'Hello world'
 */
final readonly class Normalized extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to normalize.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            TextOf::ofScalar(
                new ScalarOf(
                    static fn(): string => preg_replace('/\s+/u', ' ', trim($origin->value()))
                        ?? throw new InvalidArgumentException('Malformed UTF-8 input'),
                ),
            ),
        );
    }
}
