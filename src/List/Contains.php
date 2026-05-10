<?php

declare(strict_types=1);

namespace Primus\List;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Tells whether a list contains a value, using strict equality.
 *
 * Example:
 *     $scalar = new Contains(new ListOf(1, 2, 3), 2);
 *     echo $scalar->value() ? 'yes' : 'no'; // yes
 *
 * @template T
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class Contains extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to search in.
     * @param T $value The value to look for.
     */
    public function __construct(List_ $origin, mixed $value)
    {
        parent::__construct(
            new ScalarOf(static fn(): bool => in_array($value, $origin->value(), true)),
        );
    }
}
