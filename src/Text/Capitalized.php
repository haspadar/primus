<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} with the first character capitalized.
 *
 * Converts only the first character to uppercase
 * and leaves the rest of the text unchanged.
 *
 * Example:
 * $text = new Capitalized(new TextOf('hello'));
 * echo $text->value(); // 'Hello'
 *
 * @since 0.2
 */
final readonly class Capitalized extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        $value = $origin->value();
        parent::__construct(
            new TextOf(
                $value === ''
                    ? ''
                    : mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8')
                    . mb_substr($value, 1, null, 'UTF-8')
            )
        );
    }
}
