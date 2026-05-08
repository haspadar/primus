<?php

declare(strict_types=1);

namespace Primus\Func;

use Override;
use Primus\RuntimeException;

/**
 * Func applied multiple times sequentially.
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
     * Ctor.
     *
     * @param Func<T, T> $origin The function to repeat.
     * @param int $times Number of sequential applications.
     */
    public function __construct(private Func $origin, private int $times) {}

    #[Override]
    public function apply(mixed $input): mixed
    {
        if ($this->times <= 0) {
            throw new RuntimeException('Repeated time must be >= 1');
        }

        $result = $input;

        for ($i = 0; $i < $this->times; $i++) {
            $result = $this->origin->apply($result);
        }

        return $result;
    }
}
