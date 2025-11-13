<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

/**
 * Procedure from X with no result.
 *
 * @template X
 *
 * @since 0.3
 */
interface Proc
{
    /**
     * Execute the procedure.
     *
     * @param X $input
     */
    public function exec(mixed $input): void;
}
