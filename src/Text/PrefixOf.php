<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text segment before the first occurrence of a boundary.
 *
 * Returns everything in `$origin` up to (and excluding) the first match of
 * `$boundary`. If the boundary is absent, returns the full origin text.
 * Position lookup and slicing use {@see mb_strpos()} and {@see mb_substr()},
 * so multibyte characters are preserved as whole units.
 *
 * Construction forms:
 *
 * - `new PrefixOf(Text, Text)` — wrap origin and boundary as {@see Text}.
 * - `PrefixOf::texts(Text, Text)` — named-constructor alias of the primary ctor.
 * - `PrefixOf::strings(string, string)` — shortcut that wraps native strings
 *   in {@see TextOf::str()} before slicing.
 *
 * Example:
 *     $login = PrefixOf::strings('user@example.com', '@');
 *     echo $login->value(); // 'user'
 */
final readonly class PrefixOf extends TextEnvelope
{
    private const string ENCODING = 'UTF-8';

    /**
     * Ctor.
     *
     * @param Text $origin The text to split.
     * @param Text $boundary The text that marks the split point.
     */
    public function __construct(Text $origin, Text $boundary)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(
                    static function (string $s) use ($boundary): string {
                        $position = mb_strpos($s, $boundary->value(), 0, self::ENCODING);

                        return is_int($position)
                            ? mb_substr($s, 0, $position, self::ENCODING)
                            : $s;
                    },
                ),
            ),
        );
    }

    /**
     * Extracts the prefix before a boundary in a {@see Text}.
     *
     * @param Text $source The text to split.
     * @param Text $boundary The text that marks the split point.
     * @psalm-api
     */
    public static function texts(Text $source, Text $boundary): self
    {
        return new self($source, $boundary);
    }

    /**
     * Extracts the prefix before a boundary in a native string.
     *
     * @param string $value The string to split.
     * @param string $boundary The string that marks the split point.
     * @psalm-api
     */
    public static function strings(string $value, string $boundary): self
    {
        return new self(TextOf::str($value), TextOf::str($boundary));
    }
}
