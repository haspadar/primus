<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Scalar\Scalar;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Number lifted from a deferred numeric Scalar.
 *
 * The Scalar is evaluated lazily on each accessor call. The result
 * is cast with native PHP `(int)` and `(float)` semantics.
 *
 * Example:
 *     $n = new NumberOfScalar(new ScalarOf(static fn(): float => 2.7));
 *     $n->asInt(); // 2
 *     $n->asFloat(); // 2.7
 */
final readonly class NumberOfScalar implements Number
{
    /**
     * Ctor.
     *
     * @param Scalar<int|float> $origin The deferred numeric scalar to resolve on access.
     */
    public function __construct(private Scalar $origin) {}

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
    public function asText(): Text
    {
        return new TextOf((string) (float) $this->origin->value());
    }
}
