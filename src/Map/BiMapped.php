<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\Func\BiFunc;

/**
 * Map with each value transformed by a function of key and value while preserving keys.
 *
 * Example:
 *     $map = new BiMapped(
 *         new MapOf(['a' => 1, 'b' => 2]),
 *         new BiFuncOf(fn (string $key, int $value): string => "$key=$value"),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key:$value ";
 *     }
 *     // a:a=1 b:b=2
 *
 * @template K of array-key
 * @template V
 * @template W
 * @implements Map<K, W>
 */
final readonly class BiMapped implements Map
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose values are transformed.
     * @param BiFunc<K, V, W> $func The transformation function.
     */
    public function __construct(private Map $origin, private BiFunc $func) {}

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->origin->value() as $key => $value) {
            $pairs[$key] = $this->func->apply($key, $value);
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
            yield $key => $this->func->apply($key, $value);
        }
    }
}
