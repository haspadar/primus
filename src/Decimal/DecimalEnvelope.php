<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Override;
use Primus\Text\Text;

/**
 * Base class for Decimal decorators.
 *
 * Envelope for {@see Decimal}, delegating all projections to the origin.
 * Used as a parent for aggregates whose only job is to wrap a freshly
 * computed Decimal in the same numeric contract.
 */
abstract readonly class DecimalEnvelope implements Decimal
{
    /**
     * Ctor.
     *
     * @param Decimal $origin The wrapped decimal.
     */
    public function __construct(protected Decimal $origin) {}

    #[Override]
    final public function asInt(): int
    {
        return $this->origin->asInt();
    }

    #[Override]
    final public function asFloat(): float
    {
        return $this->origin->asFloat();
    }

    #[Override]
    final public function asText(): Text
    {
        return $this->origin->asText();
    }

    #[Override]
    final public function asString(): string
    {
        return $this->origin->asString();
    }
}
