<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} repeated multiple times.
 *
 * Example:
 *     $text = new Repeated(new TextOf('xo'), 3);
 *     echo $text->value(); // 'xoxoxo'
 *
 * @since 0.2
 */
final readonly class Repeated extends TextEnvelope
{
    public function __construct(Text $origin, int $count)
    {
        parent::__construct(
            new TextOf(
                str_repeat($origin->value(), max(0, $count))
            )
        );
    }
}
