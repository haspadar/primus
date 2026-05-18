<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\BiFuncOf;
use Primus\List\List_;

/**
 * Greatest element of a {@see List_} of comparable values.
 *
 * Composes {@see Reduced} with a `max`-style accumulator under PHP's `>`
 * comparison. The element type must be naturally comparable and
 * homogeneous (int, float, string, `DateTimeInterface`, etc.); heterogeneous
 * lists follow PHP coercion rules and produce undefined results. Equal
 * elements resolve to the first match encountered. An empty source raises
 * {@see \UnderflowException} on first projection — there is no neutral
 * element for "greatest".
 *
 * Example:
 *     $top = new HighestOf(new ListOf(1, 7, 3, 5));
 *     echo $top->value(); // 7
 *
 *     $latest = new HighestOf(new ListOf('apple', 'orange', 'banana'));
 *     echo $latest->value(); // 'orange'
 *
 * @extends ScalarEnvelope<mixed>
 */
final readonly class HighestOf extends ScalarEnvelope
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
                    $picked = $left >= $right
                        ? $left
                        : $right;

                    return $picked;
                }),
            ),
        );
    }
}
