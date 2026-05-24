<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * Map with each value transformed by a function while preserving keys.
 *
 * Construction forms:
 *
 * - `new Mapped(Map, Func)` — wrap an existing {@see Map} and the value mapper.
 * - `Mapped::ofMap(Map, Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = Mapped::ofMap(
 *         new MapOf(['a' => 1, 'b' => 2]),
 *         new FuncOf(fn (int $v): int => $v * 10),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // a=10 b=20
 *
 * @template K of array-key
 * @template V
 * @template W
 * @implements Map<K, W>
 */
final readonly class Mapped implements Map
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose values are transformed.
     * @param Func<V, W> $func The transformation function.
     */
    public function __construct(private Map $origin, private Func $func) {}

    /**
     * Transforms each value of a {@see Map} through a {@see Func}, keeping keys.
     *
     * @template L of array-key
     * @template A
     * @template B
     * @param Map<L, A> $map The map whose values are transformed.
     * @param Func<A, B> $mapper The transformation function.
     * @return self<L, A, B>
     * @psalm-api
     */
    public static function ofMap(Map $map, Func $mapper): self
    {
        return new self($map, $mapper);
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->origin->value() as $key => $value) {
            $pairs[$key] = $this->func->apply($value);
        }

        return $pairs;
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $key => $value) {
            yield $key => $this->func->apply($value);
        }
    }
}
