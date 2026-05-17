<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Escaped {@see Text} safe for HTML rendering.
 *
 * Example:
 *     $text = new HtmlEscaped(TextOf::str('<b>"A & B"</b>'));
 *     echo $text->value(); // &lt;b&gt;&quot;A &amp; B&quot;&lt;/b&gt;
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
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            ),
        );
    }
}
