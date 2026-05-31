<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Escaped {@see Text} safe for HTML rendering.
 *
 * Construction forms:
 *
 * - `new HtmlEscaped(Text)` — wrap an existing {@see Text} value.
 * - `HtmlEscaped::ofText(Text)` — named-constructor alias of the primary ctor.
 * - `HtmlEscaped::ofString(string)` — shortcut that wraps a native string in
 *   {@see TextOf::str()} before escaping.
 *
 * Example:
 *     $text = HtmlEscaped::ofText(TextOf::str('<b>"A & B"</b>'));
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

    /**
     * Escapes a {@see Text} for safe HTML rendering.
     *
     * @param Text $source The text to escape.
     * @psalm-api
     */
    public static function ofText(Text $source): self
    {
        return new self($source);
    }

    /**
     * Escapes a native string for safe HTML rendering.
     *
     * @param string $value The string to escape.
     * @psalm-api
     */
    public static function ofString(string $value): self
    {
        return new self(TextOf::str($value));
    }
}
