<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;
use Primus\RuntimeException;

/**
 * Map of pairs picked from row arrays where the index column supplies keys and the value column supplies values.
 *
 * Example:
 *     $byId = new PluckedBy(
 *         new ListOf(
 *             ['id' => 1, 'name' => 'Alice'],
 *             ['id' => 2, 'name' => 'Bob'],
 *         ),
 *         'id',
 *         'name',
 *     );
 *     // [1 => 'Alice', 2 => 'Bob']
 *
 * @template V
 * @implements Map<array-key, V>
 */
final readonly class PluckedBy implements Map
{
    /**
     * Ctor.
     *
     * @param List_<array<array-key, mixed>> $origin Source list of row arrays.
     * @param array-key $index Row column supplying pair keys.
     * @param array-key $column Row column supplying pair values.
     */
    public function __construct(
        private List_ $origin,
        private int|string $index,
        private int|string $column,
    ) {}

    #[Override]
    public function value(): array
    {
        /** @var array<array-key, V> $pairs */
        $pairs = [];

        foreach ($this->origin->value() as $position => $row) {
            if (!array_key_exists($this->index, $row)) {
                throw new RuntimeException(sprintf(
                    'PluckedBy index key %s missing in row at position %s',
                    var_export($this->index, true),
                    var_export($position, true),
                ));
            }

            if (!array_key_exists($this->column, $row)) {
                throw new RuntimeException(sprintf(
                    'PluckedBy value key %s missing in row at position %s',
                    var_export($this->column, true),
                    var_export($position, true),
                ));
            }

            $key = $row[$this->index];

            if (!is_int($key) && !is_string($key)) {
                throw new RuntimeException(sprintf(
                    'PluckedBy index value at position %s is %s, expected int or string',
                    var_export($position, true),
                    get_debug_type($key),
                ));
            }

            /** @var V $value */
            $value = $row[$this->column];

            $pairs[$key] = $value;
        }

        return $pairs;
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
