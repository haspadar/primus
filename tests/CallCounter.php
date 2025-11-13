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
final class CallCounter
{
    private int $count = 0;

    public function increment(): int
    {
        return ++$this->count;
    }

    public function total(): int
    {
        return $this->count;
    }
}
