<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * Text in uppercase.
 *
 * Converts the given text to uppercase using multibyte support.
 *
 * Example:
 *     $text = new Uppered(new TextOf('touché résumé'));
 *     echo $text->value(); // 'TOUCHÉ RÉSUMÉ'
 *
 */
final readonly class Uppered extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to uppercase.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(mb_strtoupper($origin->value(), 'UTF-8'))
        );
    }
}
