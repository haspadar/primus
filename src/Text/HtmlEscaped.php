<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;

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
    /**
     * Ctor.
     *
     * @param Text $origin The text to escape.
     */
    public function __construct(Text $origin)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): string
    {
        return htmlspecialchars($this->origin->value(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
