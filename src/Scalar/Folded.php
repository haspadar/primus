<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\BiFunc;
use Primus\List\List_;

/**
 * Left-fold of a {@see List_} with an explicit seed accumulator.
 *
 * Walks the source applying `$reducer->apply($accumulator, $next)` to every
 * element, starting from `$seed`. On an empty list returns the seed value
 * unchanged — there is no exception because the seed itself acts as the
 * neutral element. Use {@see Reduced} when no seed is available and the
 * accumulator must match the element type.
 *
 * Example:
 *     $totalLength = new Folded(
 *         new Constant(0),
 *         new ListOf('hello', 'world'),
 *         new BiFuncOf(static fn(int $sum, string $s): int => $sum + strlen($s)),
 *     );
 *     echo $totalLength->value(); // 10
 *
 *     $emptyDefaultsToSeed = new Folded(
 *         new Constant(42),
 *         new ListOf(),
 *         new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
 *     );
 *     echo $emptyDefaultsToSeed->value(); // 42
 *
 * Construction forms:
 *
 * - `new Folded(Scalar, List_, BiFunc)` — wrap seed, list and reducer.
 * - `Folded::ofSeed(Scalar, List_, BiFunc)` — named-constructor alias of the primary ctor.
 *
 * @template X
 * @template T
 * @extends ScalarEnvelope<X>
 */
final readonly class Folded extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<X> $seed The initial accumulator value.
     * @param List_<T> $source The list to fold.
     * @param BiFunc<X, T, X> $reducer The accumulator function.
     */
    public function __construct(Scalar $seed, List_ $source, BiFunc $reducer)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($seed, $source, $reducer) {
                    $accumulator = $seed->value();

                    foreach ($source as $item) {
                        $accumulator = $reducer->apply($accumulator, $item);
                    }

                    return $accumulator;
                },
            ),
        );
    }

    /**
     * Left-folds a {@see List_} with an explicit seed accumulator.
     *
     * @template Y
     * @template U
     * @param Scalar<Y> $seed The initial accumulator value.
     * @param List_<U> $list The list to fold.
     * @param BiFunc<Y, U, Y> $reducer The accumulator function.
     * @return self<Y, U>
     * @psalm-api
     */
    public static function ofSeed(Scalar $seed, List_ $list, BiFunc $reducer): self
    {
        return new self($seed, $list, $reducer);
    }
}
