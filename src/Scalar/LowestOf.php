<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\BiFuncOf;
use Primus\List\List_;

/**
 * Smallest element of a {@see List_} of comparable values.
 *
 * Composes {@see Reduced} with a `min`-style accumulator under PHP's `<`
 * comparison. The element type must be naturally comparable and
 * homogeneous (int, float, string, `DateTimeInterface`, etc.); heterogeneous
 * lists follow PHP coercion rules and produce undefined results. Equal
 * elements resolve to the first match encountered. An empty source raises
 * {@see \UnderflowException} on first projection — there is no neutral
 * element for "smallest".
 *
 * Example:
 *     $bottom = new LowestOf(new ListOf(7, 1, 3, 5));
 *     echo $bottom->value(); // 1
 *
 *     $earliest = new LowestOf(new ListOf('orange', 'apple', 'banana'));
 *     echo $earliest->value(); // 'apple'
 *
 * @extends ScalarEnvelope<mixed>
 */
final readonly class LowestOf extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<mixed> $source The list to scan.
     */
    public function __construct(List_ $source)
    {
        parent::__construct(
            new Reduced(
                $source,
                new BiFuncOf(static function (mixed $left, mixed $right): mixed {
                    /** @var mixed $picked */
                    $picked = $left <= $right
                        ? $left
                        : $right;

                    return $picked;
                }),
            ),
        );
    }
}
