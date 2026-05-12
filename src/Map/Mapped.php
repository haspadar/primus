<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * Map with each value transformed by a function while preserving keys.
 *
 * Example:
 *     $map = new Mapped(
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
