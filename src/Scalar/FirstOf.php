<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\Func;
use Primus\List\List_;

/**
 * First element in a list that satisfies a condition.
 *
 * Walks the list lazily and returns the first item for which `$condition`
 * yields `true`. If no element matches, falls back to `$fallback->value()`.
 *
 * Construction forms:
 *
 * - `new FirstOf(Func, List_, Scalar)` — wrap predicate, list and fallback.
 * - `FirstOf::list(Func, List_, Scalar)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $first = FirstOf::list(
 *         new FuncOf(fn (int $n): bool => $n > 5),
 *         new ListOf(1, 3, 7, 10),
 *         new Constant(0),
 *     );
 *     echo $first->value(); // 7
 *
 * @template T
 * @extends ScalarEnvelope<T>
 */
final readonly class FirstOf extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Func<T, bool> $condition The predicate that selects the element.
     * @param List_<T> $source The list to scan.
     * @param Scalar<T> $fallback The value returned when no element matches.
     */
    public function __construct(Func $condition, List_ $source, Scalar $fallback)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($condition, $source, $fallback) {
                    foreach ($source as $item) {
                        if ($condition->apply($item)) {
                            return $item;
                        }
                    }

                    return $fallback->value();
                },
            ),
        );
    }

    /**
     * Selects the first element in a list matching a predicate.
     *
     * @template U
     * @param Func<U, bool> $predicate The predicate that selects the element.
     * @param List_<U> $list The list to scan.
     * @param Scalar<U> $fallback The value returned when no element matches.
     * @return self<U>
     * @psalm-api
     */
    public static function list(Func $predicate, List_ $list, Scalar $fallback): self
    {
        return new self($predicate, $list, $fallback);
    }
}
