<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Exception;
use Primus\Scalar\Scalar;

/**
 * Text based on a scalar producing a string.
 */
final readonly class TextOfScalar implements Text
{
    /** @param Scalar<string> $origin */
    public function __construct(private Scalar $origin)
    {
    }

    /**
     * @throws Exception
     */
    #[\Override]
    public function value(): string
    {
        /** @var string */
        return $this->origin->value();
    }
}
