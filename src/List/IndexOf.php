<?php

declare(strict_types=1);

namespace Primus\List;

use OutOfBoundsException;
use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Tells the position of the first strict-equal occurrence of a value in a list.
 *
 * Example:
 *     $scalar = new IndexOf(new ListOf('a', 'b', 'c'), 'b');
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
}
