<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Exception;
use Primus\Func\FuncOf;
use Primus\Scalar\ScalarOf;

/**
 * {@see Text} with whitespace removed from the right side.
 *
 * Example:
 * $text = new TrimmedRight(new TextOf(" hello   "));
 * echo $text->value(); // ' hello'
 *
 * @since 0.2
 */
final readonly class TrimmedRight extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOfScalar(
                new ScalarOf(
                    new FuncOf(
                        function () use ($origin): string {
                            $trimmed = preg_replace('/\s+$/u', '', $origin->value());
                            if ($trimmed === null) {
                                throw new Exception('Malformed UTF-8 input');
                            }
                            return $trimmed;
                        }
                    )
                )
            )
        );
    }
}
