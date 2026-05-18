<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\List\List_;
use UnderflowException;

/**
 * Smallest element of a {@see List_} of comparable values.
 *
 * Walks the list and returns the smallest item under PHP's `<` comparison.
 * The element type must be naturally comparable and homogeneous (int,
 * float, string, `DateTimeInterface`, etc.) — heterogeneous lists follow
 * PHP coercion rules (`1 < "a"` etc.) and produce undefined results.
 * Equal elements resolve to the first match encountered. An empty source
 * raises {@see UnderflowException} on first projection — there is no
 * neutral element for "smallest".
 *
 * Example:
 *     $bottom = new LowestOf(new ListOf(7, 1, 3, 5));
 *     echo $bottom->value(); // 1
 *
 *     $earliest = new LowestOf(new ListOf('orange', 'apple', 'banana'));
 *     echo $earliest->value(); // 'apple'
 *
 * @template T
 * @extends ScalarEnvelope<T>
 */
final readonly class LowestOf extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $source The list to scan.
     */
    public function __construct(List_ $source)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($source) {
                    $items = iterator_to_array($source, false);

                    if ($items === []) {
                        throw new UnderflowException('Cannot pick the smallest element from an empty list');
                    }

                    return min($items);
                },
            ),
        );
    }
}
