<?php

declare(strict_types=1);

namespace Primus\Logic;

use Override;
use Primus\Text\Trimmed;

/**
 * Logic that returns true if the text is empty or whitespace-only.
 */
final readonly class IsEmpty extends LogicEnvelope
{
    #[Override]
    public function value(): bool
    {
        return (new Trimmed($this->text))->value() === '';
    }
}
