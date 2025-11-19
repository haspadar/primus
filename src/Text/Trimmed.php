<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} without leading or trailing whitespace.
 *
 * Applies {@see trim()} to the original text.
 *
 * Example:
 *     $text = new Trimmed(new TextOf('  hello  '));
 *     echo $text->value(); // 'hello'
 *
 * @since 0.1
 */
final readonly class Trimmed extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(trim($origin->value()))
        );
    }
}
