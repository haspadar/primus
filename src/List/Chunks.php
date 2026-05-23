<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List of fixed-size sub-lists carved from an origin list.
 *
 * Elements of the origin are grouped into consecutive chunks of the
 * configured size. The last chunk holds the remainder when the origin
 * size is not a multiple of the configured size.
 *
 * Construction forms:
 *
 * - `new Chunks(List_, int)` — wrap an existing {@see List_} and chunk size.
 * - `Chunks::ofList(List_, int)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Chunks::ofList(new ListOf(1, 2, 3, 4, 5), 2);
 *     foreach ($list as $chunk) {
 *         echo '[' . implode(',', $chunk->value()) . ']';
 *     }
 *     // [1,2][3,4][5]
 *
 * @template T
 * @implements List_<List_<T>>
 */
final readonly class Chunks implements List_
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to partition.
     * @param positive-int $size The size of each chunk; the last chunk may be smaller.
     */
    public function __construct(private List_ $origin, private int $size) {}

    /**
     * Partitions a {@see List_} into fixed-size sub-lists.
     *
     * @template U
     * @param List_<U> $list The list to partition.
     * @param positive-int $capacity The size of each chunk; the last chunk may be smaller.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, int $capacity): self
    {
        return new self($list, $capacity);
    }

    #[Override]
    public function value(): array
    {
        return array_map(
            static fn(array $chunk): List_ => new ListOf(...$chunk),
            array_chunk($this->origin->value(), $this->size),
        );
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
