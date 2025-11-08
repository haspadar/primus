<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Override;

/**
 * Text of a plain string.
 */
final readonly class TextOf implements Text
{
    public function __construct(private string $value)
    {
    }

    #[Override]
    public function value(): string
    {
        return $this->value;
    }
}
