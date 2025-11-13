<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

/**
 * Procedure of two arguments with no result.
 *
 * @template X
 * @template Y
 *
 * @since 0.3
 */
interface BiProc
{
    /**
     * Execute the procedure with two inputs.
     *
     * @param X $first
     * @param Y $second
     */
    public function exec(mixed $first, mixed $second): void;
}
