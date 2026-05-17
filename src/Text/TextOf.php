<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Bytes\Bytes;
use Primus\Scalar\Scalar;
use Primus\Scalar\ScalarOf;

/**
 * Convenience factory wrapping different sources as Text.
 *
 * Each named constructor reduces its input to a {@see TextOfScalar} and
 * passes it to the envelope, so every form is lazy and composable through
 * the same delegate. None of the named constructors memoize the source —
 * every {@see Text::value()} call re-evaluates the wrapped scalar or bytes.
 * Wrap in {@see \Primus\Scalar\Sticky} (or compose through it) to freeze
 * the result.
 *
 * Example:
 *     use Primus\Bytes\BytesOf;
 *     use Primus\Scalar\ScalarOf;
 *     TextOf::str('hello'); // eager string
 *     TextOf::scalar(new ScalarOf(fn() => 'hello')); // deferred
 *     TextOf::bytes(new BytesOf('hello')); // bytes wrapped as text
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

    /**
     * Wraps a {@see Bytes} sequence as Text without altering its raw bytes.
     *
     * The byte sequence is delegated lazily — the source is touched only when
     * {@see Text::value()} is called. Multibyte-aware Text decorators (length,
     * substring, ...) assume UTF-8; pass non-UTF-8 only into byte-oriented
     * consumers.
     *
     * @param Bytes $bytes The byte sequence to wrap as text.
     * @psalm-api Public factory; psalm currently scans only src/, so this
     *     annotation suppresses PossiblyUnusedMethod until an in-src consumer
     *     (e.g. a future Base64-decoded Text decorator) replaces it.
     */
    public static function bytes(Bytes $bytes): self
    {
        return new self(new TextOfScalar(new ScalarOf(static fn(): string => $bytes->value())));
    }
}
