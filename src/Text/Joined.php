<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarOf;

/**
 * Text joined from multiple parts with a separator.
 *
 * Construction forms:
 *
 * - `new Joined(string, list<Text>)` — join an array of {@see Text} parts.
 * - `Joined::ofTexts(string, list<Text>)` — named-constructor alias of the primary ctor.
 * - `Joined::ofStrings(string, string ...)` — shortcut that wraps each
 *   native string in {@see TextOf::str()} before joining.
 *
 * Example:
 *     $text = Joined::ofTexts(', ', [TextOf::str('a'), TextOf::str('b'), TextOf::str('c')]);
 *     echo $text->value(); // 'a, b, c'
 *
 *     $text = Joined::ofStrings(', ', 'a', 'b', 'c');
 *     echo $text->value(); // 'a, b, c'
 */
final readonly class Joined extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param string $separator The glue inserted between parts.
     * @param list<Text> $parts The texts to join.
     */
    public function __construct(string $separator, array $parts)
    {
        parent::__construct(
            TextOf::scalar(
                new ScalarOf(static fn(): string => implode(
                    $separator,
                    array_map(
                        static fn(Text $t): string => $t->value(),
                        $parts,
                    ),
                )),
            ),
        );
    }

    /**
     * Joins {@see Text} parts with a separator.
     *
     * @param string $glue The glue inserted between parts.
     * @param list<Text> $pieces The texts to join.
     * @psalm-api
     */
    public static function ofTexts(string $glue, array $pieces): self
    {
        return new self($glue, $pieces);
    }

    /**
     * Joins native strings with a separator.
     *
     * @param string $separator The glue inserted between parts.
     * @param string ...$parts The strings to join.
     * @psalm-api
     */
    public static function ofStrings(string $separator, string ...$parts): self
    {
        return new self(
            $separator,
            array_values(
                array_map(
                    static fn(string $part): Text => TextOf::str($part),
                    $parts,
                ),
            ),
        );
    }
}
