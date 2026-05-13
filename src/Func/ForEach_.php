<?php

declare(strict_types=1);

namespace Primus\Func;

use Primus\List\List_;

/**
 * Applies a Proc to each element of a List in iteration order.
 *
 * Example:
 *     $log = new ForEach_(
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
     * Apply the procedure to each element.
     */
    public function exec(): void
    {
        foreach ($this->list as $element) {
            $this->proc->exec($element);
        }
    }
}
