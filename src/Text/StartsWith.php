<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks whether one text starts with another.
 *
 * Delegates to {@see str_starts_with()}; byte-level comparison is safe
 * for UTF-8 because UTF-8 sequences cannot overlap byte boundaries of
 * other sequences.
 *
 * Construction forms:
 *
 * - `new StartsWith(Text, Text)` — wrap haystack and prefix as {@see Text}.
 * - `StartsWith::ofTexts(Text, Text)` — named-constructor alias of the primary ctor.
 * - `StartsWith::ofStrings(string, string)` — shortcut that wraps native strings
 *   in {@see TextOf::str()} before checking.
 *
 * Example:
 *     $starts = StartsWith::ofStrings('hello world', 'hello');
 *     echo $starts->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class StartsWith extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $haystack The text to inspect.
     * @param Text $needle The prefix to look for.
     */
    public function __construct(Text $haystack, Text $needle)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => str_starts_with($haystack->value(), $needle->value()),
            ),
        );
    }

    /**
     * Tells whether a {@see Text} starts with a prefix.
     *
     * @param Text $haystack The text to inspect.
     * @param Text $needle The prefix to look for.
     * @psalm-api
     */
    public static function ofTexts(Text $haystack, Text $needle): self
    {
        return new self($haystack, $needle);
    }

    /**
     * Tells whether a native string starts with a prefix.
     *
     * @param string $haystack The string to inspect.
     * @param string $needle The prefix to look for.
     * @psalm-api
     */
    public static function ofStrings(string $haystack, string $needle): self
    {
        return new self(TextOf::str($haystack), TextOf::str($needle));
    }
}
