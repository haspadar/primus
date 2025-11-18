<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} with left padding.
 *
 * Pads the text on the left to the specified length
 * with the given character using {@see str_pad()}.
 *
 * Example:
 *     $text = new LeftPadded(new TextOf('foo'), 6, '.');
 *     echo $text->value(); // '...foo'
 *
 * @since 0.2
 */
final readonly class LeftPadded extends TextEnvelope
{
    public function __construct(
        Text $origin,
        int $length,
        string $padChar
    ) {
        parent::__construct(
            new TextOf(
                str_pad(
                    $origin->value(),
                    $length,
                    $padChar,
                    STR_PAD_LEFT
                )
            )
        );
    }
}
