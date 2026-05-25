<?php

declare(strict_types=1);

namespace Primus\Func;

use Override;

/**
 * Cached (sticky) {@see Func}.
 *
 * Stores results of previous calls. Key is derived via `serialize($input)`,
 * which uniquely represents scalars, arrays, and objects.
 *
 * Construction forms:
 *
 * - `new StickyFunc(Func)` — wrap a function to cache its results.
 * - `StickyFunc::ofFunc(Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $doubled = StickyFunc::ofFunc(new FuncOf(fn(int $x): int => $x * 2));
 *     echo $doubled->apply(5); // 10
 *     echo $doubled->apply(5); // cached
 *
 * @template X
 * @template Y
 * @implements Func<X, Y>
 */
final class StickyFunc implements Func
{
    /**
     * @var array<string, mixed>
     * @phpstan-ignore haspadar.immutable (lazy memoization cache; idempotent externally)
     */
    private array $cache = [];

    /**
     * Ctor.
     *
     * @param Func<X, Y> $origin The function whose results are cached.
     */
    public function __construct(private readonly Func $origin) {}

    /**
     * Wraps a {@see Func} to cache its results per input.
     *
     * @template A
     * @template B
     * @param Func<A, B> $source The function whose results are cached.
     * @return self<A, B>
     * @psalm-api
     */
    public static function ofFunc(Func $source): self
    {
        return new self($source);
    }

    #[Override]
    public function apply(mixed $input): mixed
    {
        $key = serialize($input);
        $this->cache[$key] ??= $this->origin->apply($input);

        /** @psalm-suppress MixedReturnStatement Cache stores Y per contract, see @var */
        return $this->cache[$key];
    }
}
