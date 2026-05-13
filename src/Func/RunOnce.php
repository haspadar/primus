<?php

declare(strict_types=1);

namespace Primus\Func;

use Override;

/**
 * Delegates exec() to the origin only on the first call; subsequent calls are no-ops.
 *
 * Holds a private boolean flag that flips before delegating to the origin. This
 * is the single primitive in Primus that intentionally departs from the
 * readonly doctrine — memoization of "already executed" inherently requires
 * mutation. If the origin throws, the slot is still consumed — subsequent
 * calls remain no-ops.
 *
 * Example:
 *     $init = new RunOnce(new ProcOf(fn() => bootstrap()));
 *     $init->exec(null); // bootstrap() runs
 *     $init->exec(null); // no-op
 *
 * @template X
 * @implements Proc<X>
 */
final class RunOnce implements Proc
{
    /** @phpstan-ignore haspadar.immutable (RunOnce is the documented mutable-state exception in Primus — memoization of "already executed" inherently requires mutation) */
    private bool $done = false;

    /**
     * Ctor.
     *
     * @param Proc<X> $origin The procedure to run once.
     */
    public function __construct(private readonly Proc $origin) {}

    #[Override]
    public function exec(mixed $input): void
    {
        if ($this->done) {
            return;
        }

        $this->done = true;
        $this->origin->exec($input);
    }
}
