<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Primus\Func\Predicate;
use RuntimeException;

/**
 * Lazy filtered iterator.
 *
 * @template T
 * @implements Iterator<mixed, T>
 */
final class Filtered implements Iterator
{
    /**
     * @psalm-suppress NoMutableProperty
     */
    private bool $isValid = false;

    /**
     * @param Iterator<mixed, T> $origin
     * @param Predicate<T>       $predicate
     */
    public function __construct(
        private readonly Iterator $origin,
        private readonly Predicate $predicate
    ) {
    }

    #[\Override]
    public function rewind(): void
    {
        $this->origin->rewind();
        $this->advance();
    }

    #[\Override]
    public function next(): void
    {
        if (!$this->isValid) {
            throw new RuntimeException('Iterator is past the end');
        }

        $this->origin->next();
        $this->advance();
    }

    #[\Override]
    public function current(): mixed
    {
        if (!$this->isValid) {
            throw new RuntimeException('Iterator is past the end');
        }
        return $this->origin->current();
    }

    #[\Override]
    public function key(): mixed
    {
        if (!$this->isValid) {
            throw new RuntimeException('Iterator is past the end');
        }
        return $this->origin->key();
    }

    #[\Override]
    public function valid(): bool
    {
        return $this->isValid;
    }

    private function advance(): void
    {
        $this->isValid = false;

        while ($this->origin->valid()) {
            /** @var T $value */
            $value = $this->origin->current();

            if ($this->predicate->apply($value)) {
                $this->isValid = true;
                return;
            }

            $this->origin->next();
        }
    }
}
