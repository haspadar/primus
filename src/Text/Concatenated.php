<?php

declare(strict_types=1);

namespace Primus\Text;

/**
 * Text concatenated from multiple parts without a separator.
 *
 * Equivalent to {@see Joined} with an empty separator. Parts are concatenated
 * in argument order.
 *
 * Construction forms:
 *
 * - `new Concatenated(Text ...)` — concatenate variadic {@see Text} parts.
 * - `Concatenated::ofTexts(Text ...)` — named-constructor alias of the primary ctor.
 * - `Concatenated::ofStrings(string ...)` — shortcut that wraps each native
 *   string in {@see TextOf::str()} before concatenating.
 *
 * Example:
 *     $text = Concatenated::ofTexts(
 *         TextOf::str('hello, '),
 *         TextOf::str('world'),
 *     );
 *     echo $text->value(); // 'hello, world'
 *
 *     $text = Concatenated::ofStrings('hello, ', 'world');
 *     echo $text->value(); // 'hello, world'
 */
final readonly class Concatenated extends TextEnvelope
{
    private const string SEPARATOR = '';

    /**
     * Ctor.
     *
     * @param Text ...$parts The texts to concatenate.
     */
    public function __construct(Text ...$parts)
    {
        parent::__construct(new Joined(self::SEPARATOR, array_values($parts)));
    }

    /**
     * Concatenates {@see Text} parts in argument order.
     *
     * @param Text ...$pieces The texts to concatenate.
     * @psalm-api
     */
    public static function ofTexts(Text ...$pieces): self
    {
        return new self(...$pieces);
    }

    /**
     * Concatenates native strings in argument order.
     *
     * @param string ...$parts The strings to concatenate.
     * @psalm-api
     */
    public static function ofStrings(string ...$parts): self
    {
        return new self(
            ...array_map(
                static fn(string $part): Text => TextOf::str($part),
                $parts,
            ),
        );
    }
}
