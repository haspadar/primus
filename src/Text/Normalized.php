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
 * Construction forms:
 *
 * - `new Normalized(Text)` — wrap an existing {@see Text} value.
 * - `Normalized::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `Normalized::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before normalizing.
 *
 * Example:
 *     $text = Normalized::ofText(TextOf::str(" Hello \n\t world "));
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
            TextOf::scalar(
                new ScalarOf(
                    static fn(): string => preg_replace('/\s+/u', ' ', trim($origin->value()))
                        ?? throw new InvalidArgumentException('Malformed UTF-8 input'),
                ),
            ),
        );
    }

    /**
     * Normalizes whitespace in a {@see Text}.
     *
     * @param Text $source The text to normalize.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Normalizes whitespace in a native string.
     *
     * @param string $value The string to normalize.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
