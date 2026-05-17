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
 * Example:
 *     $has = new Contains(TextOf::str('hello world'), TextOf::str('lo wo'));
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
}
