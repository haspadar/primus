<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Length of {@see Text}, measured in multibyte characters.
 *
 * Example:
 * $length = new LengthOf(new TextOf('Café Noël'));
 * echo $length->value(); // 9
 *
 * @extends ScalarEnvelope<int>
 * @psalm-pure
 */
final readonly class LengthOf extends ScalarEnvelope
{
    public function __construct(Text $origin)
    {
        /** @var ScalarOf<int> $scalar */
        $scalar = new ScalarOf(
            fn (): int => mb_strlen($origin->value(), 'UTF-8')
        );

        parent::__construct($scalar);
    }
}
