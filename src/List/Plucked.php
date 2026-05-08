<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;
use Primus\RuntimeException;

/**
 * List of values picked at a single key from every row of a source list of rows.
 *
 * Example:
 *     $names = new Plucked(
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
 * @since 0.3
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
