<?php

declare(strict_types=1);

namespace Primus\List;

use OutOfBoundsException;
use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Tells the position of the first strict-equal occurrence of a value in a list.
 *
 * Construction forms:
 *
 * - `new IndexOf(List_, mixed)` — wrap a {@see List_} and the needle.
 * - `IndexOf::list(List_, mixed)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = IndexOf::list(new ListOf('a', 'b', 'c'), 'b');
 *     echo $scalar->value(); // 1
 *
 * @template T
 * @extends ScalarEnvelope<int>
 */
final readonly class IndexOf extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param List_<T> $origin The list to search in.
     * @param T $value The value to locate.
     */
    public function __construct(List_ $origin, mixed $value)
    {
        parent::__construct(
            new ScalarOf(static function () use ($origin, $value): int {
                $index = 0;

                foreach ($origin->value() as $item) {
                    if ($item === $value) {
                        return $index;
                    }

                    $index++;
                }

                throw new OutOfBoundsException('Value not found in list');
            }),
        );
    }

    /**
     * Locates the index of the first strict-equal occurrence of a value in a {@see List_}.
     *
     * @template U
     * @param List_<U> $list The list to search in.
     * @param U $needle The value to locate.
     * @return self<U>
     * @psalm-api
     */
    public static function list(List_ $list, mixed $needle): self
    {
        return new self($list, $needle);
    }
}
