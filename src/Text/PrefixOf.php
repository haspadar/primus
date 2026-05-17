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
 * Example:
 *     $login = new PrefixOf(
 *         TextOf::str('user@example.com'),
 *         TextOf::str('@'),
 *     );
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
}
