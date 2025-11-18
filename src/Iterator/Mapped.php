<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Primus\Func\Func;

/**
 * @template X
 * @template Y
 * @implements Iterator<mixed, Y>
 *
 * @since 0.5
 */
final class Mapped implements Iterator
{
    /** @psalm-suppress NoMutableProperty */
    private int $position = 0;

    /**
     * @param Iterator<mixed, X> $origin
     * @param Func<X, Y> $func
     */
    public function __construct(
        private readonly Iterator $origin,
        private readonly Func $func,
    ) {
    }

    #[\Override]
    public function rewind(): void
    {
        $this->position = 0;
        $this->origin->rewind();
    }

    /**
     * @return Y
     */
    #[\Override]
    public function current(): mixed
    {
        if (!$this->valid()) {
            throw new \RuntimeException('Mapped: current() past end');
        }

        /** @var X $value */
        $value = $this->origin->current();

        return $this->func->apply($value);
    }

    #[\Override]
    public function key(): int
    {
        if (!$this->valid()) {
            throw new \RuntimeException('Mapped: key() past end');
        }

        return $this->position;
    }

    #[\Override]
    public function next(): void
    {
        if (!$this->valid()) {
            throw new \RuntimeException('Mapped: next() past end');
        }

        $this->position++;
        $this->origin->next();
    }

    #[\Override]
    public function valid(): bool
    {
        return $this->origin->valid();
    }
}
