<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;
use Primus\Scalar\Scalar;

/**
 * Text based on a scalar producing a string.
 *
 * @internal Internal delegate of {@see TextOf::scalar()}. Callers should
 *     compose text from a {@see Scalar} through `TextOf::scalar(...)`
 *     instead of instantiating this class directly. Cactoos exposes its
 *     equivalent publicly to support value equality through `equals()`;
 *     Primus does not model Text identity, so a public surface here would
 *     be redundant.
 *
 * Construction forms:
 *
 * - `new TextOfScalar(Scalar)` — wrap a scalar producing a string.
 * - `TextOfScalar::ofScalar(Scalar)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $text = TextOf::scalar(new ScalarOf(static fn(): string => 'hello'));
 *     echo $text->value(); // 'hello'
 */
final readonly class TextOfScalar implements Text
{
    /**
     * Ctor.
     *
     * @param Scalar<string> $origin The scalar producing the string value.
     */
    public function __construct(private Scalar $origin) {}

    /**
     * Wraps a {@see Scalar} producing a string as a {@see Text}.
     *
     * @param Scalar<string> $source The scalar producing the string value.
     * @psalm-api
     */
    public static function ofScalar(Scalar $source): self
    {
        return new self($source);
    }

    #[Override]
    public function value(): string
    {
        return $this->origin->value();
    }
}
