<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\Func\Func;

/**
 * List with each element transformed by a function.
 *
 * Construction forms:
 *
 * - `new Mapped(List_, Func)` — wrap an existing {@see List_} and mapper.
 * - `Mapped::ofList(List_, Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Mapped::ofList(
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

    /**
     * Transforms each element of a {@see List_} through a {@see Func}.
     *
     * @template A
     * @template B
     * @param List_<A> $list The list whose elements are transformed.
     * @param Func<A, B> $mapper The transformation function.
     * @return self<A, B>
     * @psalm-api
     */
    public static function ofList(List_ $list, Func $mapper): self
    {
        return new self($list, $mapper);
    }

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
