<?php

declare(strict_types=1);

namespace Primus\Text;

use InvalidArgumentException;
use Override;

/**
 * Text with whitespace removed from the left side.
 *
 * Example:
 *     $text = new TrimmedLeft(new TextOf(" hello "));
 *     echo $text->value(); // 'hello '
 *
 * @since 0.2
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
        parent::__construct($origin);
    }

    #[Override]
    public function value(): string
    {
        return preg_replace('/^\s+/u', '', $this->origin->value())
            ?? throw new InvalidArgumentException('Malformed UTF-8 input');
    }
}
