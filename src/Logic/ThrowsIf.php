<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

use Primus\Exception;

/**
 * Throws an exception if a {@see Logic} condition is met or not met.
 *
 * Use this class to express assertions declaratively.
 *
 * Example:
 * (new ThrowsIf(new IsEmail(new TextOf("abc")), "Invalid email"))->whenFalse();
 *
 * @psalm-pure
 */
final readonly class ThrowsIf
{
    public function __construct(
        private Logic $condition,
        private string $message
    ) {
    }

    /**
     * @throws Exception
     */
    public function whenTrue(): void
    {
        if ($this->condition->value()) {
            throw new Exception($this->message);
        }
    }

    /**
     * @throws Exception
     */
    public function whenFalse(): void
    {
        if (!$this->condition->value()) {
            throw new Exception($this->message);
        }
    }
}
