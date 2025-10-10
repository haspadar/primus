<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

/**
 * {@see Logic} that returns true if the text is a valid email.
 *
 * @psalm-pure
 */
final readonly class IsEmail extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        return filter_var($this->text->value(), FILTER_VALIDATE_EMAIL) !== false;
    }
}
