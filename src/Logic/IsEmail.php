<?php

declare(strict_types=1);

namespace Primus\Logic;

use Override;

/**
 * Logic that returns true if the text is a valid email.
 */
final readonly class IsEmail extends LogicEnvelope
{
    #[Override]
    public function value(): bool
    {
        return filter_var($this->text->value(), FILTER_VALIDATE_EMAIL) !== false;
    }
}
