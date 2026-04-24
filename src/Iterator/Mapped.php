<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Override;
use Primus\Func\Func;
use RuntimeException;

/**
 * Iterator that lazily transforms each element of the origin iterator using the provided function.
 *
 * @template X
 * @template Y
 * @implements Iterator<mixed, Y>
 * @since 0.5
 */
final class Mapped implements Iterator
{
    /** @phpstan-ignore haspadar.immutable */
    private int $position = 0;

    /**
     * Ctor.
     *
     * @param Iterator<mixed, X> $origin The origin iterator.
     * @param Func<X, Y> $func The function used to transform elements.
     */
    public function __construct(private readonly Iterator $origin, private readonly Func $func) {}

    #[Override]
    public function rewind(): void
    {
        $this->position = 0;
        $this->origin->rewind();
    }

    #[Override]
    public function current(): mixed
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Mapped: current() past end');
        }

        /** @var X $value */
        $value = $this->origin->current();

        return $this->func->apply($value);
    }

    #[Override]
    public function key(): int
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Mapped: key() past end');
        }

        return $this->position;
    }

    #[Override]
    public function next(): void
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Mapped: next() past end');
        }

        $this->position++;
        $this->origin->next();
    }

    #[Override]
    public function valid(): bool
    {
        return $this->origin->valid();
    }
}
