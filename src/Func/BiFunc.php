<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

/**
 * Function of two arguments.
 *
 * @template X
 * @template Y
 * @template Z
 *
 * @since 0.3
 */
interface BiFunc
{
    /**
     * Apply the function to the inputs.
     *
     * @param X $first
     * @param Y $second
     * @return Z
     */
    public function apply(mixed $first, mixed $second): mixed;
}
