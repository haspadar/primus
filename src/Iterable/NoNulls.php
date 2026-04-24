<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Generator;
use IteratorAggregate;
use Override;
use RuntimeException;
use Traversable;

/**
 * Iterable that forbids NULL values.
 *
 * @template T
 * @implements IteratorAggregate<int, T>
 * @since 0.5
 */
final readonly class NoNulls implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param Traversable<mixed, T|null> $origin The iterable validated for non-null values; nulls trigger RuntimeException.
     */
    public function __construct(private Traversable $origin) {}

    #[Override]
    public function getIterator(): Generator
    {
        $position = 0;

        foreach ($this->origin as $value) {
            if ($value === null) {
                throw new RuntimeException('Null value encountered in NoNulls iterator');
            }

            yield $position => $value;

            $position++;
        }
    }
}
