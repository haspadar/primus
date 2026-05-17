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
 * Example:
 *     $domain = new SuffixOf(
 *         TextOf::ofString('user@example.com'),
 *         TextOf::ofString('@'),
 *     );
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
}
