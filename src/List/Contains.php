<?php

declare(strict_types=1);

namespace Primus\List;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Tells whether a list contains a value, using strict equality.
 *
 * Construction forms:
 *
 * - `new Contains(List_, mixed)` — wrap a {@see List_} and the needle.
 * - `Contains::ofList(List_, mixed)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = Contains::ofList(new ListOf(1, 2, 3), 2);
 *     echo $scalar->value() ? 'yes' : 'no'; // yes
 *
 * @template T
 * @extends ScalarEnvelope<bool>
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

    /**
     * Tells whether a {@see List_} contains a value, using strict equality.
     *
     * @template U
     * @param List_<U> $list The list to search in.
     * @param U $needle The value to look for.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, mixed $needle): self
    {
        return new self($list, $needle);
    }
}
