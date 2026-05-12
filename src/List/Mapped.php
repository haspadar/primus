<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * List with each element transformed by a function.
 *
 * Example:
 *     $list = new Mapped(
 *         new ListOf(1, 2, 3),
 *         new FuncOf(fn (int $x): int => $x * 10),
 *     );
 *     foreach ($list as $value) {
 *         echo $value . ' ';
 *     }
 *     // 10 20 30
 *
 * @template X
 * @template Y
 * @implements List_<Y>
 */
final readonly class Mapped implements List_
{
    /**
     * Ctor.
     *
     * @param List_<X> $origin The list whose elements are transformed.
     * @param Func<X, Y> $func The transformation function.
     */
    public function __construct(private List_ $origin, private Func $func) {}

    #[Override]
    public function value(): array
    {
        return iterator_to_array($this->getIterator(), false);
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $item) {
            yield $this->func->apply($item);
        }
    }
}
