<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Override;
use RuntimeException;

/**
 * Concatenates multiple iterators into a single iterator.
 *
 * @template T
 * @implements Iterator<int, T>
 * @since 0.5
 */
final class Joined implements Iterator
{
    /** @phpstan-ignore haspadar.immutable */
    private int $position = 0;

    /** @var Iterator<int, Iterator<int, T>> */
    private readonly Iterator $outer;

    /**
     * @var Iterator<int, T>
     * @phpstan-ignore haspadar.immutable
     */
    private Iterator $current;

    /**
     * Ctor.
     *
     * @param array<int, Iterator<int, T>> $iterators The iterators to concatenate.
     */
    public function __construct(array $iterators)
    {
        $this->outer = new IteratorOf($iterators);
        $this->current = new IteratorOf([]);
    }

    #[Override]
    public function rewind(): void
    {
        $this->position = 0;
        $this->outer->rewind();

        if (!$this->outer->valid()) {
            $this->current = new IteratorOf([]);

            return;
        }

        /** @psalm-suppress PossiblyNullPropertyAssignmentValue Guarded by valid() above */
        $this->current = $this->outer->current();
        /** @psalm-suppress PossiblyNullReference Guarded by valid() above */
        $this->current->rewind();

        $this->advance();
    }

    #[Override]
    public function current(): mixed
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Joined iterator is past the end');
        }

        return $this->current->current();
    }

    #[Override]
    public function key(): int
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator key is undefined because iterator is past the end');
        }

        return $this->position;
    }

    #[Override]
    public function next(): void
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Joined iterator is past the end');
        }

        $this->current->next();
        $this->position++;

        $this->advance();
    }

    #[Override]
    public function valid(): bool
    {
        return $this->current->valid();
    }

    /**
     * Move to the next non-empty iterator.
     */
    private function advance(): void
    {
        while (!$this->current->valid() && $this->outer->valid()) {
            $this->outer->next();

            if ($this->outer->valid()) {
                /** @psalm-suppress PossiblyNullPropertyAssignmentValue Guarded by valid() above */
                $this->current = $this->outer->current();
                /** @psalm-suppress PossiblyNullReference Guarded by valid() above */
                $this->current->rewind();
            }
        }
    }
}
