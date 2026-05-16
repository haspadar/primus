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
 * Example:
 *     $ends = new EndsWith(TextOf::ofString('hello world'), TextOf::ofString('world'));
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
}
