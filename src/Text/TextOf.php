<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\Scalar;
use Primus\Scalar\ScalarOf;

/**
 * Convenience factory wrapping different sources as Text.
 *
 * Each named constructor reduces its input to a {@see TextOfScalar} and
 * passes it to the envelope, so every form is lazy and composable through
 * the same delegate.
 *
 * Example:
 *     TextOf::str('hello'); // eager string
 *     TextOf::scalar(new ScalarOf(fn() => 'hello')); // deferred
 */
final readonly class TextOf extends TextEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to delegate to.
     */
    private function __construct(Text $origin)
    {
        parent::__construct($origin);
    }

    /**
     * Wraps a native string.
     *
     * @param string $value The string to wrap.
     */
    public static function str(string $value): self
    {
        return new self(new TextOfScalar(new ScalarOf(static fn(): string => $value)));
    }

    /**
     * Wraps a Scalar producing a string.
     *
     * @param Scalar<string> $scalar The deferred string source.
     */
    public static function scalar(Scalar $scalar): self
    {
        return new self(new TextOfScalar($scalar));
    }
}
