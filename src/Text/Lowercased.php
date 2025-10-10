<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} in lowercase.
 *
 * Converts the given text to lowercase using multibyte support.
 *
 * Example:
 * $text = new Lowercased(new TextOf('CAFÉ & TÜRKİYE'));
 * echo $text->value(); // 'café & türkiye'
 *
 * @psalm-pure
 * @since 0.1
 */
final readonly class Lowercased extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(mb_strtolower($origin->value()))
        );
    }
}
