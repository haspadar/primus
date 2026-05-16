<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Func\Func;
use Primus\Scalar\ScalarOf;

/**
 * Text with its value transformed by a function.
 *
 * Stores no extra fields — the function is captured inside a lazy scalar
 * and the envelope delegates every projection to it.
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
    public function __construct(Text $origin, Func $func)
    {
        parent::__construct(
            TextOf::ofScalar(
                new ScalarOf(static fn(): string => $func->apply($origin->value())),
            ),
        );
    }
}
