<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * {@see Text} sanitized for HTML output.
 *
 * Strips all tags and escapes special characters using {@see htmlspecialchars}.
 *
 * Example:
 * $text = new HtmlSanitized(new TextOf('<b>John & "Jane"</b>'));
 * echo $text->value(); // 'John &amp; &quot;Jane&quot;'
 *
 * @psalm-pure
 */
final readonly class HtmlSanitized extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(
                htmlspecialchars(
                    strip_tags($origin->value()),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                )
            )
        );
    }
}
