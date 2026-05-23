<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\BiFunc;
use Primus\List\List_;
use UnderflowException;

/**
 * Left-fold of a {@see List_} via a {@see BiFunc} accumulator.
 *
 * Walks the source taking the first item as the initial accumulator, then
 * combines each subsequent item into it through `$reducer->apply($acc, $next)`.
 * An empty source raises {@see UnderflowException} on first projection —
 * there is no neutral element without an explicit seed.
 *
 * Construction forms:
 *
 * - `new Reduced(List_, BiFunc)` — wrap list and reducer.
 * - `Reduced::ofList(List_, BiFunc)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $sum = Reduced::ofList(
 *         new ListOf(1, 2, 3, 4),
 *         new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
 *     );
 *     echo $sum->value(); // 10
 *
 * @template T
 * @extends ScalarEnvelope<T>
 */
final readonly class Reduced extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $source The list to fold.
     * @param BiFunc<T, T, T> $reducer The accumulator function.
     */
    public function __construct(List_ $source, BiFunc $reducer)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($source, $reducer) {
                    $items = iterator_to_array($source, false);

                    if ($items === []) {
                        throw new UnderflowException('Cannot reduce an empty list');
                    }

                    $accumulator = $items[0];
                    $length = count($items);

                    for ($index = 1; $index < $length; $index++) {
                        $accumulator = $reducer->apply($accumulator, $items[$index]);
                    }

                    return $accumulator;
                },
            ),
        );
    }

    /**
     * Left-folds a {@see List_} via a {@see BiFunc} accumulator without a seed.
     *
     * @template U
     * @param List_<U> $list The list to fold.
     * @param BiFunc<U, U, U> $reducer The accumulator function.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, BiFunc $reducer): self
    {
        return new self($list, $reducer);
    }
}
