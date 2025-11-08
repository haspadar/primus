<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} joined from multiple {@see Text} parts with a separator.
 *
 * Example:
 * $text = new Joined(', ', [new TextOf('a'), new TextOf('b'), new TextOf('c')]);
 * echo $text->value(); // 'a, b, c'
 *
 * @since 0.2
 */
final readonly class Joined extends TextEnvelope
{
    /**
     * @param iterable<Text> $parts
     */
    public function __construct(string $separator, iterable $parts)
    {
        parent::__construct(
            new TextOf(
                implode(
                    $separator,
                    array_map(
                        fn (Text $t): string => $t->value(),
                        is_array($parts) ? $parts : iterator_to_array($parts, false)
                    )
                )
            )
        );
    }
}
