<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map exposing a contiguous slice of an origin map while preserving keys.
 *
 * Offsets and lengths follow {@see array_slice()} semantics with
 * preserve_keys=true: negative offset counts from the end, omitted length
 * extends to the end, negative length stops that many positions before
 * the end.
 *
 * Example:
 *     $map = new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3]), 1);
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // b=2 c=3
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class Sliced extends MapEnvelope
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to slice.
     * @param int $offset The starting position; negative counts from the end.
     * @param int $length The maximum number of entries; defaults to extending to the end.
     */
    public function __construct(
        Map $origin,
        private int $offset,
        private int $length = PHP_INT_MAX,
    ) {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): array
    {
        return array_slice($this->origin->value(), $this->offset, $this->length, true);
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
