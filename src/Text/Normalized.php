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
 * {@see Text} with normalized whitespace.
 *
 * Replaces multiple spaces, tabs, and newlines
 * with a single space and trims leading/trailing whitespace.
 *
 * Example:
 * $text = new Normalized(new TextOf(" Hello \n\t  world "));
 * echo $text->value(); // 'Hello world'
 *
 * @since 0.2
 */
final readonly class Normalized extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOfScalar(
                new ScalarOf(
                    new FuncOf(
                        function () use ($origin): string {
                            $normalized = preg_replace('/\s+/u', ' ', trim($origin->value()));
                            if ($normalized === null) {
                                throw new Exception('Malformed UTF-8 input');
                            }
                            return $normalized;
                        }
                    )
                )
            )
        );
    }
}
