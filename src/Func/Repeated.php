<?php

declare(strict_types=1);

namespace Primus\Func;

use Override;
use Primus\RuntimeException;

/**
 * Func applied multiple times sequentially.
 *
 * Construction forms:
 *
 * - `new Repeated(Func, int)` — wrap a function with a repetition count.
 * - `Repeated::ofFunc(Func, int)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $func = Repeated::ofFunc(
 *         new FuncOf(fn(int $x): int => $x + 1),
 *         3
 *     );
 *     echo $func->apply(5); // 8
 *
 * @template T
 * @implements Func<T, T>
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

    /**
     * Applies a {@see Func} multiple times sequentially.
     *
     * @template U
     * @param Func<U, U> $source The function to repeat.
     * @param int $count Number of sequential applications.
     * @return self<U>
     * @psalm-api
     */
    public static function ofFunc(Func $source, int $count): self
    {
        return new self($source, $count);
    }

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
