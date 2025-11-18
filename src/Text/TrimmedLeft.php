<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} with whitespace removed from the left side.
 *
 * Example:
 *     $text = new TrimmedLeft(new TextOf("   hello "));
 *     echo $text->value(); // 'hello '
 *
 * @since 0.2
 */
final readonly class TrimmedLeft extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(
                (string)preg_replace('/^\s+/u', '', $origin->value())
            )
        );
    }
}
