<?php
/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Mono\Numeric;

use Mono\Scalar\Scalar;

/**
 * @template T of int|float|string
 * @extends Scalar<T>
 */
interface Number extends Scalar
{
    public function value();
}