<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Override;
use RuntimeException;

/**
 * Simple iterator over a PHP array.
 *
 * @template T
 * @implements Iterator<array-key, T>
 * @since 0.5
 */
final class IteratorOf implements Iterator
{
    /**
     * @var list<array-key>
     * @phpstan-ignore haspadar.immutable
     */
    private array $keys = [];

    /** @phpstan-ignore haspadar.immutable */
    private int $position = 0;

    /**
     * Ctor.
     *
     * @param array<array-key, T> $items The items to iterate over.
     */
    public function __construct(private readonly array $items) {}

    #[Override]
    public function rewind(): void
    {
        $this->keys = array_keys($this->items);
        $this->position = 0;
    }

    #[Override]
    public function current(): mixed
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator is past the end');
        }

        return $this->items[$this->keys[$this->position]];
    }

    #[Override]
    public function key(): int|string
    {
        if (!$this->valid()) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator key is undefined because iterator is past the end');
        }

        return $this->keys[$this->position];
    }

    #[Override]
    public function next(): void
    {
        $this->position++;
    }

    #[Override]
    public function valid(): bool
    {
        return $this->position < count($this->keys);
    }
}
