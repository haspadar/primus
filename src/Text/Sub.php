<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * Substring of a {@see Text}.
 *
 * Uses {@see mb_substr()} to return a portion of the text.
 * Equivalent to {@see mb_substr($text, $start, PHP_INT_MAX, 'UTF-8')}.
 *
 * Example:
 * $text = new Sub(new TextOf('hello world'), 0, 5);
 * echo $text->value(); // 'hello'
 *
 * @since 0.1
 */
final readonly class Sub extends TextEnvelope
{
    public function __construct(Text $text, int $start, int $length = PHP_INT_MAX)
    {
        parent::__construct(
            new TextOf(mb_substr($text->value(), $start, $length, 'UTF-8'))
        );
    }
}
