<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Represents a lazily-evaluated value of any type.
 *
 * Serves as a generic interface for deferred computation and value composition.
 * Used as a base abstraction for all primitive-like types (Text, Logic, Number, etc).
 *
 * @template T
 * @psalm-pure
 */
interface Scalar
{
    /**
     * Returns the computed value.
     *
     * @return T The value represented by this scalar.
     */
    public function value();
}
