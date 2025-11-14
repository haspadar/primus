<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use InvalidArgumentException;

/**
 * Logical OR over multiple {@see Scalar<bool>}.
 *
 * Returns true if at least one provided scalar evaluates to true.
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class OrOf extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$conditions
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                function () use ($conditions): bool {
                    if ($conditions === []) {
                        throw new InvalidArgumentException('OrOf requires at least one condition');
                    }
                    return array_any($conditions, fn ($condition) => $condition->value());
                }
            )
        );
    }
}
