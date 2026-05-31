<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text with replaced substrings.
 *
 * Replaces one or multiple search strings with replacements.
 *
 * Construction forms:
 *
 * - `new Replaced(Text, string|list<string>, string|list<string>)` — wrap an
 *   existing {@see Text} value.
 * - `Replaced::ofText(Text, string|list<string>, string|list<string>)` —
 *   named-constructor alias of the primary ctor.
 * - `Replaced::ofString(string, string|list<string>, string|list<string>)` —
 *   shortcut that wraps a native string in {@see TextOf::str()} before
 *   replacing.
 *
 * Example:
 *     $text = Replaced::ofString('<b>Hello & bye</b>', ['<b>', '</b>', '&'], ['', '', 'and']);
 *     echo $text->value(); // 'Hello and bye'
 */
final readonly class Replaced extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The origin text.
     * @param string|list<string> $search The substrings to search for.
     * @param string|list<string> $replacement The replacements.
     */
    public function __construct(Text $origin, string|array $search, string|array $replacement)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => str_replace($search, $replacement, $s)),
            ),
        );
    }

    /**
     * Replaces substrings in a {@see Text}.
     *
     * @param Text $source The origin text.
     * @param string|list<string> $search The substrings to search for.
     * @param string|list<string> $replacement The replacements.
     * @psalm-api
     */
    public static function ofText(
        Text $source,
        string|array $search,
        string|array $replacement,
    ): self {
        return new self($source, $search, $replacement);
    }

    /**
     * Replaces substrings in a native string.
     *
     * @param string $value The string to operate on.
     * @param string|list<string> $search The substrings to search for.
     * @param string|list<string> $replacement The replacements.
     * @psalm-api
     */
    public static function ofString(
        string $value,
        string|array $search,
        string|array $replacement,
    ): self {
        return new self(TextOf::str($value), $search, $replacement);
    }
}
