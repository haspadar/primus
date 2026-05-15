<?php

declare(strict_types=1);

namespace Primus\Tests\Integer\Fakes;

use Override;
use Primus\Integer\Integer;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Integer fake that counts how many times each projection is invoked.
 *
 * Used to verify caching behaviour of decorators such as {@see \Primus\Integer\Sticky}.
 */
final class CountingInteger implements Integer
{
    public int $intCalls = 0;
    public int $floatCalls = 0;
    public int $textCalls = 0;

    public function __construct(
        private readonly int $intValue,
        private readonly float $floatValue,
        private readonly string $textValue = '',
    ) {}

    #[Override]
    public function asInt(): int
    {
        ++$this->intCalls;

        return $this->intValue;
    }

    #[Override]
    public function asFloat(): float
    {
        ++$this->floatCalls;

        return $this->floatValue;
    }

    #[Override]
    public function asText(): Text
    {
        ++$this->textCalls;

        return new TextOf($this->textValue);
    }
}
