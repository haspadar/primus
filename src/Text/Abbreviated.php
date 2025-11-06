<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * Abbreviated {@see Text}.
 *
 * Truncates the origin text to a maximum length and appends an ellipsis.
 * If the text length does not exceed the limit, it is returned unchanged.
 *
 * Example:
 * $text = new Abbreviated(new TextOf('Hello, world!'), 8);
 * echo $text->value(); // 'Hello, w…'
 *
 * @since 0.1
 */
final readonly class Abbreviated extends TextEnvelope
{
    public function __construct(Text $origin, int $limit = 50)
    {
        if ($limit <= 0) {
            parent::__construct(new TextOf(''));
            return;
        }

        $length = new LengthOfText($origin);
        if ($length->value() <= $limit) {
            parent::__construct($origin);
            return;
        }

        $truncated = new Sub($origin, 0, $limit - 1)->value() . '…';
        parent::__construct(new TextOf($truncated));
    }
}
