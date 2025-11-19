<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests;

/**
 * @since 0.3
 */
final class CountCalls
{
    private int $calls = 0;

    public function record(int $value): int
    {
        $this->calls++;
        return $value;
    }

    public function total(): int
    {
        return $this->calls;
    }
}
