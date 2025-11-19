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
        if ($this->times <= 0) {
            throw new \RuntimeException('Repeated time must be >= 1');
        }

        $result = $input;
        for ($i = 0; $i < $this->times; $i++) {
            $result = $this->origin->apply($result);
        }

        return $result;
    }
}
