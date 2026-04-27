<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks if text is falsy in a boolean context.
 *
 * Returns true for the strings PHP treats as false in `if ($str)`,
 * namely '' and '0'. Any other string yields false.
 *
 * Example:
 *     $empty = new IsEmpty(new TextOf('0'));
 *     echo $empty->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class IsEmpty extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $text The text to check.
     */
    public function __construct(Text $text)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): bool => !(bool) $text->value(),
            ),
        );
    }
}
