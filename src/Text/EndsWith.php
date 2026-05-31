<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks whether one text ends with another.
 *
 * Delegates to {@see str_ends_with()}; byte-level comparison is safe
 * for UTF-8 because UTF-8 sequences cannot overlap byte boundaries of
 * other sequences.
 *
 * Construction forms:
 *
 * - `new EndsWith(Text, Text)` — wrap haystack and suffix as {@see Text}.
 * - `EndsWith::ofTexts(Text, Text)` — named-constructor alias of the primary ctor.
 * - `EndsWith::ofStrings(string, string)` — shortcut that wraps native strings
 *   in {@see TextOf::str()} before checking.
 *
 * Example:
 *     $ends = EndsWith::ofStrings('hello world', 'world');
 *     echo $ends->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class EndsWith extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $haystack The text to inspect.
     * @param Text $needle The suffix to look for.
     */
    public function __construct(Text $haystack, Text $needle)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => str_ends_with($haystack->value(), $needle->value()),
            ),
        );
    }

    /**
     * Tells whether a {@see Text} ends with a suffix.
     *
     * @param Text $haystack The text to inspect.
     * @param Text $needle The suffix to look for.
     * @psalm-api
     */
    public static function ofTexts(Text $haystack, Text $needle): self
    {
        return new self($haystack, $needle);
    }

    /**
     * Tells whether a native string ends with a suffix.
     *
     * @param string $haystack The string to inspect.
     * @param string $needle The suffix to look for.
     * @psalm-api
     */
    public static function ofStrings(string $haystack, string $needle): self
    {
        return new self(TextOf::str($haystack), TextOf::str($needle));
    }
}
