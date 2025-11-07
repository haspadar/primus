<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Exception;

/**
 * Logical AND over multiple {@see Scalar<bool>}.
 *
 * Returns true only if all provided scalars evaluate to true.
 *
 * Example:
 * $and = new AndOf(new True_(), new False_());
 * echo $and->value(); // false
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class AndOf extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$conditions
     */
    public function __construct(Scalar ...$conditions)
    {
        /** @var ScalarOf<bool> $scalar */
        $scalar = new ScalarOf(
            function () use ($conditions): bool {
                if ($conditions === []) {
                    throw new Exception('AndOf requires at least one condition');
                }

                return array_reduce(
                    $conditions,
                    fn (bool $carry, Scalar $cond): bool => $carry && $cond->value(),
                    true,
                );
            },
        );

        parent::__construct($scalar);
    }
}
