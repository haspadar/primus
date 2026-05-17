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
 * Example:
 *     $first = new FirstOf(
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
}
