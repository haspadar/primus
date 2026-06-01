<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks whether one text contains another.
 *
 * Delegates to {@see str_contains()}; byte-level search is safe for
 * UTF-8 because UTF-8 sequences cannot overlap byte boundaries of
 * other sequences.
 *
 * Construction forms:
 *
 * - `new Contains(Text, Text)` — wrap haystack and needle as {@see Text}.
 * - `Contains::ofTexts(Text, Text)` — named-constructor alias of the primary ctor.
 * - `Contains::ofStrings(string, string)` — shortcut that wraps native strings
 *   in {@see TextOf::str()} before searching.
 *
 * Example:
 *     $has = Contains::ofStrings('hello world', 'lo wo');
 *     echo $has->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class Contains extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $haystack The text to search within.
     * @param Text $needle The substring to look for.
     */
    public function __construct(Text $haystack, Text $needle)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => str_contains($haystack->value(), $needle->value()),
            ),
        );
    }

    /**
     * Tells whether the first {@see Text} contains the second.
     *
     * @param Text $haystack The text to search within.
     * @param Text $needle The substring to look for.
     * @psalm-api
     */
    public static function ofTexts(Text $haystack, Text $needle): self
    {
        return new self($haystack, $needle);
    }

    /**
     * Tells whether the first native string contains the second.
     *
     * @param string $haystack The string to search within.
     * @param string $needle The substring to look for.
     * @psalm-api
     */
    public static function ofStrings(string $haystack, string $needle): self
    {
        return new self(TextOf::str($haystack), TextOf::str($needle));
    }
}
