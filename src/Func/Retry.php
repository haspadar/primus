<?php

declare(strict_types=1);

namespace Primus\Func;

use Throwable;

/**
 * Re-executes {@see Func} if it throws.
 *
 * Example:
 *     $func = new Retry(
 *         new FuncOf(fn (int $x): int => random_int(0, 1) ? $x : throw new \RuntimeException()),
 *         3
 *     );
 *     $func->apply(42);
 *
 * @template X
 * @template Y
 * @implements Func<X, Y>
 * @since 0.3
 */
final readonly class Retry implements Func
{
    /**
     * @param Func<X, Y> $origin
     */
    public function __construct(
        private Func $origin,
        private int $attempts = 3,
        private int $delayMs = 0,
    ) {
    }

    #[\Override]
    public function apply(mixed $input): mixed
    {
        $errors = [];
        for ($i = 0; $i < max(1, $this->attempts); $i++) {
            try {
                return $this->origin->apply($input);
            } catch (Throwable $e) {
                $errors[] = $e;
                if ($i + 1 < $this->attempts && $this->delayMs > 0) {
                    usleep($this->delayMs * 1000);
                }
            }
        }

        throw $errors[array_key_last($errors)];
    }
}
