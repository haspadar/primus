<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * Cached (sticky) {@see Func}.
 *
 * Stores results of previous calls. Key is derived via `serialize($input)`,
 * which uniquely represents scalars, arrays, and objects.
 *
 * Example:
 *     $doubled = new StickyFunc(new FuncOf(fn(int $x): int => $x * 2));
 *     echo $doubled->apply(5);  // 10
 *     echo $doubled->apply(5);  // cached
 *
 * @template X
 * @template Y
 * @implements Func<X, Y>
 * @since 0.3
 */
final class StickyFunc implements Func
{
    /**
     * @var array<string, mixed>
     * @psalm-suppress NoMutableProperty
     */
    private array $cache = [];

    /**
     * @param Func<X, Y> $origin
     */
    public function __construct(private readonly Func $origin)
    {
    }

    #[\Override]
    public function apply(mixed $input): mixed
    {
        $key = serialize($input);
        return $this->cache[$key] ??= $this->origin->apply($input);
    }
}
