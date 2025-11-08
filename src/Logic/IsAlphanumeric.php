<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

/**
 * {@see Logic} that returns true if text contains only alphanumeric characters (A–Z, a–z, 0–9).
 *
 * Example:
 * new IsAlphanumeric(new TextOf("abc123")) → true
 *
 */
final readonly class IsAlphanumeric extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        return ctype_alnum($this->text->value());
    }
}
