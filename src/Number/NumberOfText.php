<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Text\Text;

/**
 * Number parsed from the textual representation of a Text.
 *
 * Parsing follows native PHP `(int)` and `(float)` cast semantics on
 * the Text's value: leading numeric prefix is read, the rest is dropped.
 *
 * Example:
 *     $n = new NumberOfText(new TextOf('3.14'));
 *     $n->asInt(); // 3
 *     $n->asFloat(); // 3.14
 */
final readonly class NumberOfText implements Number
{
    /**
     * Ctor.
     *
     * @param Text $origin The textual source to parse on access.
     */
    public function __construct(private Text $origin) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->origin->value();
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->origin->value();
    }

    #[Override]
    public function asText(): string
    {
        return (string) (float) $this->origin->value();
    }
}
