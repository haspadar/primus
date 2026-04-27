<?php

declare(strict_types=1);

namespace Primus\List;

/**
 * List with elements in reverse order.
 *
 * Example:
 *     $list = new Reversed(new ListOf(1, 2, 3));
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 321
 *
 * @template T
 * @extends ListEnvelope<T>
 * @since 0.3
 */
final readonly class Reversed extends ListEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to reverse.
     */
    public function __construct(List_ $origin)
    {
        parent::__construct(
            new ListOf(...array_reverse($origin->value())),
        );
    }
}
