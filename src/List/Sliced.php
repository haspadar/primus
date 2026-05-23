<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List exposing a contiguous slice of an origin list.
 *
 * Offsets and lengths follow {@see array_slice()} semantics without
 * preserving keys: negative offset counts from the end, omitted length
 * extends to the end, negative length stops that many positions before
 * the end.
 *
 * Construction forms:
 *
 * - `new Sliced(List_, int, int = PHP_INT_MAX)` — wrap an existing {@see List_}, offset and length.
 * - `Sliced::ofList(List_, int, int = PHP_INT_MAX)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Sliced::ofList(new ListOf(1, 2, 3, 4, 5), 1, 3);
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 234
 *
 * @template T
 * @extends ListEnvelope<T>
 */
final readonly class Sliced extends ListEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to slice.
     * @param int $offset The starting position; negative counts from the end.
     * @param int $length The maximum number of elements; defaults to extending to the end.
     */
    public function __construct(
        List_ $origin,
        private int $offset,
        private int $length = PHP_INT_MAX,
    ) {
        parent::__construct($origin);
    }

    /**
     * Exposes a contiguous slice of a {@see List_}.
     *
     * @template U
     * @param List_<U> $list The list to slice.
     * @param int $start The starting position; negative counts from the end.
     * @param int $count The maximum number of elements; defaults to extending to the end.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, int $start, int $count = PHP_INT_MAX): self
    {
        return new self($list, $start, $count);
    }

    #[Override]
    public function value(): array
    {
        return array_slice($this->origin->value(), $this->offset, $this->length);
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
