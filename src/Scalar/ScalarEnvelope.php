<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Envelope for {@see Scalar}, delegating all calls to the origin.
 *
 * Useful as a base class for scalar decorators.
 *
 * @template T
 * @implements Scalar<T>
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
     * @return T
     */
    #[\Override]
    public function value()
    {
        return $this->origin->value();
    }
}
