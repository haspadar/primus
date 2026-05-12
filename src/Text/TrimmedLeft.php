<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Primus\Func\FuncOf;

/**
 * Text with whitespace removed from the left side.
 *
 * Example:
 *     $text = new TrimmedLeft(new TextOf(" hello "));
 *     echo $text->value(); // 'hello '
 */
final readonly class TrimmedLeft extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to trim on the left.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new Mapped(
                $origin,
                new FuncOf(static fn(string $s): string => preg_replace('/^\s+/u', '', $s)
                    ?? throw new InvalidArgumentException('Malformed UTF-8 input')),
            ),
        );
    }
}
