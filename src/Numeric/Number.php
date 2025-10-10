<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Numeric;

use Override;
use Primus\Scalar\Scalar;

/**
 * @template T of int|float|string
 * @extends Scalar<T>
 */
interface Number extends Scalar
{
    #[Override]
    public function value();
}
