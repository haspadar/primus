<?php

declare(strict_types=1);

namespace Primus\Func;

/**
 * {@see Func} applied multiple times sequentially.
 *
 * Example:
 *     $func = new Repeated(
 *         new FuncOf(fn(int $x): int => $x + 1),
 *         3
 *     );
 *     echo $func->apply(5); // 8
 *
 * @template T
 * @implements Func<T, T>
 * @since 0.3
 */
final readonly class Repeated implements Func
{
    /**
     * @param Func<T, T> $origin
     */
    public function __construct(
        private Func $origin,
        private int $times
    ) {
    }

    #[\Override]
    public function apply(mixed $input): mixed
    {
        $result = $input;
        $limit = max(1, $this->times);

        for ($i = 0; $i < $limit; $i++) {
            $result = $this->origin->apply($result);
        }

        return $result;
    }
}
