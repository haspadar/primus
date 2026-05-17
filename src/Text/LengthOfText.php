<?php

declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarEnvelope;
use Primus\Scalar\ScalarOf;

/**
 * Length of {@see Text}, measured in multibyte characters.
 *
 * Example:
 *     $length = new LengthOfText(TextOf::str('Café Noël'));
 *     echo $length->value(); // 9
 *
 * @extends ScalarEnvelope<int>
 */
final readonly class LengthOfText extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Text $origin The text to measure.
     */
    public function __construct(Text $origin)
    {
        parent::__construct(
            new ScalarOf(
                static fn(): int => mb_strlen($origin->value(), 'UTF-8'),
            ),
        );
    }
}
