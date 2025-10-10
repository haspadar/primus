<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

use Primus\Text\Text;

/**
 * Envelope for {@see Logic}, delegating the call to the origin.
 *
 * @psalm-pure
 */
abstract readonly class LogicEnvelope implements Logic
{
    public function __construct(protected Text $text)
    {
    }

    #[\Override]
    abstract public function value(): bool;
}
