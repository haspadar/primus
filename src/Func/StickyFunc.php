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
 * Example:
 *     $doubled = new StickyFunc(new FuncOf(fn(int $x): int => $x * 2));
 *     echo $doubled->apply(5); // 10
 *     echo $doubled->apply(5); // cached
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
     * @phpstan-ignore haspadar.immutable
     */
    private array $cache = [];

    /**
     * Ctor.
     *
     * @param Func<X, Y> $origin The function whose results are cached.
     */
    public function __construct(private readonly Func $origin) {}

    #[Override]
    public function apply(mixed $input): mixed
    {
        $key = serialize($input);
        $this->cache[$key] ??= $this->origin->apply($input);

        /** @psalm-suppress MixedReturnStatement Cache stores Y per contract, see @var */
        return $this->cache[$key];
    }
}
