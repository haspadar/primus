<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} in uppercase.
 *
 * Converts the given text to uppercase using multibyte support.
 *
 * Example:
 * $text = new Uppercased(new TextOf('touché résumé'));
 * echo $text->value(); // 'TOUCHÉ RÉSUMÉ'
 *
 * @psalm-pure
 */
final readonly class Uppercased extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(mb_strtoupper($origin->value()))
        );
    }
}
