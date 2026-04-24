<?php

declare(strict_types=1);

namespace Primus\Iterator;

use Iterator;
use Override;
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
    /** @phpstan-ignore haspadar.immutable */
    private bool $isValid = false;

    /**
     * Ctor.
     *
     * @param Iterator<mixed, T> $origin The origin iterator.
     * @param Predicate<T> $predicate The predicate used to filter values.
     */
    public function __construct(
        private readonly Iterator $origin,
        private readonly Predicate $predicate,
    ) {}

    #[Override]
    public function rewind(): void
    {
        $this->origin->rewind();
        $this->advance();
    }

    #[Override]
    public function next(): void
    {
        if (!$this->isValid) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator is past the end');
        }

        $this->origin->next();
        $this->advance();
    }

    #[Override]
    public function current(): mixed
    {
        if (!$this->isValid) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator is past the end');
        }

        return $this->origin->current();
    }

    #[Override]
    public function key(): mixed
    {
        if (!$this->isValid) {
            /** @phpstan-ignore missingType.checkedException */
            throw new RuntimeException('Iterator is past the end');
        }

        return $this->origin->key();
    }

    #[Override]
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
