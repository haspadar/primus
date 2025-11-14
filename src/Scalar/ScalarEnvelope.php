<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Throwable;

/**
 * Base class for scalar decorators.
 *
 * Envelope for {@see Scalar}, delegating all calls to the origin.
 * Used as a parent for classes like {@see Sticky} or {@see Ternary}.
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.1
 */
abstract readonly class ScalarEnvelope implements Scalar
{
    /**
     * @param Scalar<T> $origin
     */
    public function __construct(protected Scalar $origin)
    {
    }

    /**
     * @throws Throwable
     * @return T
     */
    #[\Override]
    final public function value()
    {
        return $this->origin->value();
    }
}
