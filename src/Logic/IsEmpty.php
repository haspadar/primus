<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

use Primus\Text\Trimmed;

/**
 * {@see Logic} that returns true if the text is empty or whitespace-only.
 *
 */
final readonly class IsEmpty extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        return (new Trimmed($this->text))->value() === '';
    }
}
