<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Exception;
use Primus\Func\FuncOf;

/**
 * Logical XOR of multiple {@see Scalar<bool>} values.
 *
 * Returns true when exactly one scalar is true.
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class Xor_ extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$scalars
     */
    public function __construct(Scalar ...$scalars)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(
                    function () use ($scalars): bool {
                        if ($scalars === []) {
                            throw new Exception('No conditions provided');
                        }

                        $count = 0;
                        foreach ($scalars as $scalar) {
                            if ($scalar->value()) {
                                $count++;
                            }
                        }

                        return $count === 1;
                    }
                )
            )
        );
    }
}
