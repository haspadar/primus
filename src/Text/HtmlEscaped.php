<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

/**
 * Escaped {@see Text} safe for HTML rendering.
 *
 * Example:
 *     $text = new HtmlEscaped(new TextOf('<b>"A & B"</b>'));
 *     echo $text->value(); // &lt;b&gt;&quot;A &amp; B&quot;&lt;/b&gt;
 *
 * @since 0.2
 */
final readonly class HtmlEscaped extends TextEnvelope
{
    public function __construct(Text $origin)
    {
        parent::__construct(
            new TextOf(
                htmlspecialchars($origin->value(), ENT_QUOTES | ENT_HTML5, 'UTF-8')
            )
        );
    }
}
