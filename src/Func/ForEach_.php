<?php

declare(strict_types=1);

namespace Primus\Func;

use Primus\List\List_;

/**
 * Applies a Proc to each element of a List in iteration order.
 *
 * Construction forms:
 *
 * - `new ForEach_(List_, Proc)` — wrap a list and the procedure to apply.
 * - `ForEach_::ofList(List_, Proc)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $log = ForEach_::ofList(
 *         new ListOf(['a', 'b']),
 *         new ProcOf(fn(string $s) => error_log($s)),
 *     );
 *     $log->exec(); // error_log('a'); error_log('b');
 *
 * @template T
 */
final readonly class ForEach_
{
    /**
     * Ctor.
     *
     * @param List_<T> $list The list to iterate over.
     * @param Proc<T> $proc The procedure to apply to each element.
     */
    public function __construct(private List_ $list, private Proc $proc) {}

    /**
     * Applies a {@see Proc} to each element of a {@see List_} in iteration order.
     *
     * @template U
     * @param List_<U> $source The list to iterate over.
     * @param Proc<U> $action The procedure to apply to each element.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $source, Proc $action): self
    {
        return new self($source, $action);
    }

    /**
     * Apply the procedure to each element.
     *
     * @psalm-api
     */
    public function exec(): void
    {
        foreach ($this->list as $element) {
            $this->proc->exec($element);
        }
    }
}
