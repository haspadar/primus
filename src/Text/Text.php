<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\Scalar;

/**
 * Represents a string value.
 *
 * Used for composition and decoration of string-based logic.
 *
 * @extends Scalar<string>
 */
interface Text extends Scalar
{
    /**
     * Returns the string value represented by this object.
     */
    #[\Override]
    public function value(): string;
}
