<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical negation of a {@see Scalar<bool>}.
 *
 * Example:
 *     $scalar = new Not(new ScalarOf(fn() => false));
 *     echo $scalar->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class Not extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> $origin
     */
    public function __construct(Scalar $origin)
    {
        parent::__construct(
            new ScalarOf(fn (): bool => !$origin->value())
        );
    }
}
