<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\RuntimeException;

/**
 * List of values picked at a single key from every row of a source list of rows.
 *
 * Construction forms:
 *
 * - `new Plucked(List_, int|string)` — wrap a list of rows and the column key.
 * - `Plucked::ofList(List_, int|string)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $names = Plucked::ofList(
 *         new ListOf(
 *             ['id' => 1, 'name' => 'Alice'],
 *             ['id' => 2, 'name' => 'Bob'],
 *         ),
 *         'name',
 *     );
 *     // ['Alice', 'Bob']
 *
 * @template V
 * @implements List_<V>
 */
final readonly class Plucked implements List_
{
    /**
     * Ctor.
     *
     * @param List_<array<array-key, V>> $origin Source list of row arrays.
     * @param array-key $key Column key to pluck from every row.
     */
    public function __construct(private List_ $origin, private int|string $key) {}

    /**
     * Picks a column from every row of a {@see List_} of row arrays.
     *
     * @template U
     * @param List_<array<array-key, U>> $list Source list of row arrays.
     * @param array-key $column Column key to pluck from every row.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list, int|string $column): self
    {
        return new self($list, $column);
    }

    #[Override]
    public function value(): array
    {
        $values = [];

        foreach ($this->origin->value() as $position => $row) {
            if (!array_key_exists($this->key, $row)) {
                throw new RuntimeException(sprintf(
                    'Plucked key %s missing in row at position %s',
                    var_export($this->key, true),
                    var_export($position, true),
                ));
            }

            $values[] = $row[$this->key];
        }

        return $values;
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
