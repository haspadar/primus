<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

/**
 * Function from I to O.
 *
 * @template I
 * @template O
 *
 * @since 0.3
 */
interface Func
{
    /**
     * Apply the function to the input.
     *
     * @param I $input
     * @return O
     */
    public function apply(mixed $input): mixed;
}
