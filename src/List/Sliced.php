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
 * Example:
 *     $list = new Sliced(new ListOf(1, 2, 3, 4, 5), 1, 3);
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
