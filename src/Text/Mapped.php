<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;
use Primus\Func\Func;

/**
 * Text with its value transformed by a function.
 *
 * Example:
 *     $text = new Mapped(
 *         TextOf::ofString('hello'),
 *         new FuncOf(strtoupper(...)),
 *     );
 *     echo $text->value(); // 'HELLO'
 */
final readonly class Mapped extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text whose value is transformed.
     * @param Func<string, string> $func The transformation function.
     */
    public function __construct(Text $origin, private Func $func)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function value(): string
    {
        return $this->func->apply($this->origin->value());
    }
}
