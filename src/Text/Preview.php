<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} preview truncated to a max length with ellipsis.
 *
 * If the text exceeds the limit, it is truncated and suffixed with '…'.
 *
 * Example:
 * $text = new Preview(new TextOf('Hello, world!'), 8);
 * echo $text->value(); // 'Hello, w…'
 *
 * @psalm-pure
 * @since 0.1
 */
final readonly class Preview extends TextEnvelope
{
    public function __construct(Text $origin, int $limit = 50)
    {
        if ($limit < 1) {
            $value = '';
        } elseif (new LengthOf($origin)->value() <= $limit) {
            $value = $origin->value();
        } else {
            $value = new TruncatedRight($origin, $limit - 1)->value() . '…';
        }

        parent::__construct(new TextOf($value));
    }
}
