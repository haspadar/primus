<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;
use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Length of {@see Text}, measured in multibyte characters.
 *
 * Example:
 * $length = new LengthOfText(new TextOf('Café Noël'));
 * echo $length->value(); // 9
 *
 * @extends ScalarEnvelope<int>
 * @since 0.3
 */
final readonly class LengthOfText extends ScalarEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(fn (): int => mb_strlen($origin->value(), 'UTF-8'))
            )
        );
    }
}
