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
 * Logical AND over multiple {@see Scalar<bool>}.
 *
 * Returns true only if all provided scalars evaluate to true.
 *
 * Example:
 * $and = new And_(new True_(), new False_());
 * echo $and->value(); // false
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class And_ extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$conditions
     */
    public function __construct(Scalar ...$conditions)
    {
        /** @var FuncOf<mixed, bool> $func */
        $func = new FuncOf(function () use ($conditions): bool {
            if ($conditions === []) {
                throw new Exception('And_ requires at least one condition');
            }

            foreach ($conditions as $condition) {
                if (!$condition->value()) {
                    return false;
                }
            }

            return true;
        });
        parent::__construct(new ScalarOf($func));
    }
}
