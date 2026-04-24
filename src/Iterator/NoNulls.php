<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Override;
use RuntimeException;

/**
 * Iterator that forbids null values.
 *
 * @template T
 * @implements Iterator<mixed, T>
 * @since 0.5
 */
final class NoNulls implements Iterator
{
    /** @phpstan-ignore haspadar.immutable */
    private int $position = 0;

    /**
     * Ctor.
     *
     * @param Iterator<mixed, T|null> $origin The iterator validated for non-null values; nulls trigger RuntimeException on access.
     */
    public function __construct(private readonly Iterator $origin) {}

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
            throw new RuntimeException('Iterator is past the end');
        }

        $value = $this->origin->current();

        if ($value === null) {
            throw new RuntimeException('Null value encountered in NoNulls iterator');
        }

        return $value;
    }

    #[Override]
    public function key(): int
    {
        if (!$this->valid()) {
            throw new RuntimeException('Iterator key is undefined because iterator is past the end');
        }

        return $this->position;
    }

    #[Override]
    public function next(): void
    {
        if (!$this->valid()) {
            throw new RuntimeException('Iterator is past the end');
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
