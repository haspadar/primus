<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

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
    #[Override]
    public function value(): array
    {
        return array_reverse($this->origin->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
