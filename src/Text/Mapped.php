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
 * Construction forms:
 *
 * - `new Mapped(Text, Func)` — wrap an existing {@see Text} value and mapper.
 * - `Mapped::ofText(Text, Func)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $text = Mapped::ofText(
 *         TextOf::str('hello'),
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
            TextOf::scalar(
                new ScalarOf(static fn(): string => $func->apply($origin->value())),
            ),
        );
    }

    /**
     * Transforms the value of a {@see Text} through a {@see Func}.
     *
     * @param Text $source The text whose value is transformed.
     * @param Func<string, string> $mapper The transformation function.
     * @psalm-api
     */
    public static function ofText(Text $source, Func $mapper): self
    {
        return new self($source, $mapper);
    }
}
