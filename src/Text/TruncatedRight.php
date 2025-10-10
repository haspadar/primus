<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Exception;

/**
 * {@see Text} truncated from the right.
 *
 * Uses {@see mb_substr()} to return at most `$length` characters from the left.
 *
 * Example:
 * $text = new TruncatedRight(new TextOf('hello world'), 5);
 * echo $text->value(); // 'hello'
 *
 * @psalm-pure
 * @since 0.1
 */
final readonly class TruncatedRight extends TextEnvelope
{
    public function __construct(Text $text, int $length)
    {
        if ($length < 0) {
            throw new Exception('Length must be non-negative');
        }

        parent::__construct(
            new TextOf(mb_substr($text->value(), 0, $length, 'UTF-8'))
        );
    }
}
