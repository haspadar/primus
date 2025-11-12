<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\BiFunc;
use Primus\Func\FuncOf;
use Primus\Sequence\Sequence;

/**
 * Reduced {@see Scalar}.
 *
 * Reduces a {@see Sequence} of items into a single value
 * using a {@see BiFunc} and an initial identity value.
 * Evaluation is lazy and performed once per {@see value()} call.
 *
 * Example:
 * $sum = new Reduced(
 *     new BiFuncOf(fn(int $a, int $b): int => $a + $b),
 *     0,
 *     new SequenceOf([1, 2, 3])
 * );
 * echo $sum->value(); // 6
 *
 * @template T
 * @extends ScalarEnvelope<T>
 *
 * @since 0.3
 */
final readonly class Reduced extends ScalarEnvelope
{
    /**
     * @param BiFunc<T, T, T> $func
     * @param T $identity
     * @param Sequence<T> $sequence
     */
    public function __construct(BiFunc $func, mixed $identity, Sequence $sequence)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(function () use ($func, $identity, $sequence): mixed {
                    $acc = $identity;
                    foreach ($sequence as $item) {
                        $acc = $func->apply($acc, $item);
                    }
                    return $acc;
                })
            )
        );
    }
}
