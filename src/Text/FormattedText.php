<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text formatted from a {@see Text} pattern via {@see sprintf()}.
 *
 * The pattern uses the PHP sprintf specification (`%s`, `%d`, `%f`,
 * positional `%1$s`, etc.). Arguments are restricted to int, float and
 * string; bool and null are intentionally rejected to keep the format
 * call type-safe.
 *
 * Width and precision specifiers (`%5s`, `%.3s`) count bytes, not
 * Unicode codepoints — multibyte values may pad or truncate at byte
 * boundaries. The pattern itself is byte-safe for plain `%s` placeholders.
 *
 * Do not pass untrusted patterns: a hostile precision such as
 * `%.999999999s` can allocate a large buffer.
 *
 * Example:
 *     $text = new FormattedText(
 *         TextOf::ofString('Hello, %s! You have %d messages.'),
 *         'world',
 *         5,
 *     );
 *     echo $text->value(); // 'Hello, world! You have 5 messages.'
 */
final readonly class FormattedText extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $pattern The sprintf pattern.
     * @param int|float|string ...$arguments The values substituted into the pattern.
     */
    public function __construct(Text $pattern, int|float|string ...$arguments)
    {
        parent::__construct(
            new Mapped(
                $pattern,
                new FuncOf(static fn(string $p): string => sprintf($p, ...$arguments)),
            ),
        );
    }
}
