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
 */
abstract readonly class LogicEnvelope implements Logic
{
    /**
     * Ctor.
     *
     * @param Text $text The text to evaluate.
     */
    public function __construct(protected Text $text)
    {
    }

    #[\Override]
    abstract public function value(): bool;
}
