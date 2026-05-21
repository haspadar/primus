<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Countable;
use Primus\Text\Text;

/**
 * Length of a Text or any {@see Countable}/array as a {@see Scalar<int>}.
 *
 * Named constructors dispatch on the source family:
 *
 * - `LengthOf::text(Text)` — count of Unicode codepoints via `mb_strlen`.
 * - `LengthOf::countable(array|Countable)` — count of elements via `count()`.
 *
 * Each form re-evaluates the source on every {@see Scalar::value()}
 * call — wrap in {@see Sticky} to memoize.
 *
 * Example:
 *     LengthOf::text(TextOf::str('Café Noël'))->value(); // 9
 *     LengthOf::countable(new ListOf(1, 2, 3))->value(); // 3
 *     LengthOf::countable(['a' => 1, 'b' => 2])->value(); // 2
 *
 * @extends ScalarEnvelope<int>
 */
final readonly class LengthOf extends ScalarEnvelope
{
    /**
     * Sole point of construction; reached through the named factories.
     *
     * @param Scalar<int> $origin
     */
    private function __construct(Scalar $origin)
    {
        parent::__construct($origin);
    }

    /**
     * Wraps a {@see Text} length in Unicode codepoints.
     *
     * @param Text $text Source text
     * @psalm-api
     */
    public static function text(Text $text): self
    {
        return new self(
            new ScalarOf(static fn(): int => mb_strlen($text->value(), 'UTF-8')),
        );
    }

    /**
     * Wraps the element count of any array or {@see Countable} (incl. List_, Map).
     *
     * @param array<array-key, mixed>|Countable $countable Source collection
     * @psalm-api
     */
    public static function countable(array|Countable $countable): self
    {
        return new self(
            new ScalarOf(static fn(): int => count($countable)),
        );
    }
}
