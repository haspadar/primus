<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text with replaced substrings.
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
}
