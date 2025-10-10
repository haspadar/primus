<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * Text of a plain string.
 *
 * @psalm-pure
 */
final readonly class TextOf implements Text
{
    public function __construct(private string $value)
    {
    }

    #[\Override]
    public function value(): string
    {
        return $this->value;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }
}
