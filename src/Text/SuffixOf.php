<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text segment after the first occurrence of a boundary.
 *
 * Returns everything in `$origin` after the first match of `$boundary`. If
 * the boundary is absent, returns an empty text. Position lookup and slicing
 * use {@see mb_strpos()} and {@see mb_substr()}, so multibyte characters are
 * preserved as whole units.
 *
 * Construction forms:
 *
 * - `new SuffixOf(Text, Text)` — wrap origin and boundary as {@see Text}.
 * - `SuffixOf::texts(Text, Text)` — named-constructor alias of the primary ctor.
 * - `SuffixOf::strings(string, string)` — shortcut that wraps native strings
 *   in {@see TextOf::str()} before slicing.
 *
 * Example:
 *     $domain = SuffixOf::strings('user@example.com', '@');
 *     echo $domain->value(); // 'example.com'
 */
final readonly class SuffixOf extends TextEnvelope
{
    private const string ENCODING = 'UTF-8';
    private const string EMPTY = '';

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
                        $boundaryValue = $boundary->value();
                        $position = mb_strpos($s, $boundaryValue, 0, self::ENCODING);

                        if (!is_int($position)) {
                            return self::EMPTY;
                        }

                        return mb_substr(
                            $s,
                            $position + mb_strlen($boundaryValue, self::ENCODING),
                            null,
                            self::ENCODING,
                        );
                    },
                ),
            ),
        );
    }

    /**
     * Extracts the suffix after a boundary in a {@see Text}.
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
     * Extracts the suffix after a boundary in a native string.
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
