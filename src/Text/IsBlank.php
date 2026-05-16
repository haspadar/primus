<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Checks whether the text is empty or contains only Unicode whitespace.
 *
 * Treats both ASCII whitespace and Unicode whitespace (including
 * non-breaking spaces, line/paragraph separators, etc.) as blank.
 *
 * Example:
 *     $blank = new IsBlank(TextOf::ofString(" \t\n"));
 *     echo $blank->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class IsBlank extends ScalarEnvelope
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
                static fn(): bool => preg_match('/^\s*$/u', $text->value()) === 1,
            ),
        );
    }
}
