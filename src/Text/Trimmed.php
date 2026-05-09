<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\FuncOf;

/**
 * Text without leading or trailing whitespace.
 *
 * Applies {@see trim()} to the original text.
 *
 * Example:
 *     $text = new Trimmed(new TextOf(' hello '));
 *     echo $text->value(); // 'hello'
 *
 * @since 0.1
 */
final readonly class Trimmed extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => trim($s)),
            ),
        );
    }
}
