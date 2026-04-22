<?php

declare(strict_types=1);

namespace Primus\Logic;

use Primus\Scalar\Scalar;

/**
 * A logical boolean component.
 *
 * Represents a boolean condition.
 *
 * @extends Scalar<bool>
 *
 */
interface Logic extends Scalar
{
    #[\Override]
    public function value(): bool;

}
