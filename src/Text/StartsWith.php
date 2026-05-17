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
 * Example:
 *     $starts = new StartsWith(TextOf::str('hello world'), TextOf::str('hello'));
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
}
