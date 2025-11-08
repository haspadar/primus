<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

/**
 * {@see Logic} that returns true if text represents a valid numeric value.
 *
 * Uses PHP's {@see is_numeric()} to determine if the string is a number.
 *
 * Example:
 * new IsNumeric(new TextOf("123")) → true
 * new IsNumeric(new TextOf("3.14")) → true
 * new IsNumeric(new TextOf("1e10")) → true
 * new IsNumeric(new TextOf("abc")) → false
 *
 */
final readonly class IsNumeric extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        $value = $this->text->value();

        return is_numeric($value) && trim($value) === $value;
    }
}
