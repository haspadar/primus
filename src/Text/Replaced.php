<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} with replaced substrings.
 *
 * Replaces one or multiple search strings with replacements.
 *
 * Example:
 *     $text = new Replaced(
 *         new TextOf('<b>Hello & bye</b>'),
 *         ['<b>', '</b>', '&'],
 *         ['', '', 'and']
 *     );
 *     echo $text->value(); // 'Hello and bye'
 *
 * @since 0.2
 */
final readonly class Replaced extends TextEnvelope
{
    /**
     * @param string|string[] $search
     * @param string|string[] $replacement
     */
    public function __construct(
        Text $origin,
        string|array $search,
        string|array $replacement
    ) {
        parent::__construct(
            new TextOf(
                str_replace($search, $replacement, $origin->value())
            )
        );
    }
}
