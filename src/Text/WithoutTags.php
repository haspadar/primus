<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} without HTML tags.
 *
 * Strips all HTML tags from the origin text using {@see strip_tags()}.
 *
 * Example:
 * $text = new WithoutTags(new TextOf('<b>John & "Jane"</b>'));
 * echo $text->value(); // 'John & "Jane"'
 *
 */
final readonly class WithoutTags extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(
                strip_tags($origin->value())
            )
        );
    }
}
