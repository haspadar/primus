<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Func\FuncOf;

/**
 * Text with whitespace removed from the right side.
 *
 * Example:
 *     $text = new TrimmedRight(TextOf::str(" hello "));
 *     echo $text->value(); // ' hello'
 */
final readonly class TrimmedRight extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the right.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => preg_replace('/\s+$/u', '', $s)
                    ?? throw new InvalidArgumentException('Malformed UTF-8 input')),
            ),
        );
    }
}
