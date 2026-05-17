<?php

declare(strict_types=1);

namespace Primus\Scalar;

use InvalidArgumentException;
use Primus\List\List_;

/**
 * Element at a given position in a {@see List_}.
 *
 * Walks the list and returns the item whose zero-based index equals
 * `$position`. If the list is shorter than `$position + 1` elements, the
 * fallback `Scalar` provides the value instead. A negative position is
 * rejected with {@see InvalidArgumentException} — use an explicit
 * `count(...) - n` expression if "from the end" is intended.
 *
 * Example:
 *     $second = new ItemAt(
 *         1,
 *         new ListOf('a', 'b', 'c'),
 *         new Constant('-'),
 *     );
 *     echo $second->value(); // 'b'
 *
 *     $tenth = new ItemAt(
 *         10,
 *         new ListOf('a', 'b'),
 *         new Constant('-'),
 *     );
 *     echo $tenth->value(); // '-'
 *
 * @template T
 * @extends ScalarEnvelope<T>
 */
final readonly class ItemAt extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param int $position The zero-based index of the element to return.
     * @param List_<T> $source The list to look up the element in.
     * @param Scalar<T> $fallback The value returned when the position is missing.
     */
    public function __construct(int $position, List_ $source, Scalar $fallback)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($position, $source, $fallback) {
                    if ($position < 0) {
                        throw new InvalidArgumentException(
                            sprintf('ItemAt position must be non-negative, %d given', $position),
                        );
                    }

                    $cursor = 0;

                    foreach ($source as $item) {
                        if ($cursor === $position) {
                            return $item;
                        }

                        $cursor++;
                    }

                    return $fallback->value();
                },
            ),
        );
    }
}
