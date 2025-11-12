<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\FuncOf;

/**
 * Logical negation of a {@see Scalar<bool>}.
 *
 * Example:
 *     $scalar = new Not(
 *         new ScalarOf(new FuncOf(fn(): bool => false))
 *     );
 *     echo $scalar->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class Not extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> $origin
     */
    public function __construct(Scalar $origin)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(
                    fn (): bool => !$origin->value()
                )
            )
        );
    }
}
