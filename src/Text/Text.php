<?php

declare(strict_types=1);

namespace Primus\Text;

use Override;
use Primus\Scalar\Scalar;

/**
 * Represents a string value.
 *
 * Used for composition and decoration of string-based logic.
 *
 * @extends Scalar<string>
 */
interface Text extends Scalar
{
    #[Override]
    public function value(): string;
}
