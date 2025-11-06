<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

use Primus\Scalar\Scalar;

/**
 * A logical boolean component.
 *
 * Represents a boolean condition.
 *
 * @extends Scalar<bool>
 *
 */
interface Logic extends Scalar
{
    /**
     * Whether the condition is logically true.
     */
    #[\Override]
    public function value(): bool;

}
