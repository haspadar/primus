<?php

declare(strict_types=1);

namespace Primus\Logic;

use Primus\Text\Text;

/**
 * Logic that returns true if a {@see Text} is a valid URL.
 *
 * Example:
 *     new IsUrl(new TextOf("https://example.com")) → true
 *     new IsUrl(new TextOf("not-a-url")) → false
 *
 */
final readonly class IsUrl extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        return filter_var($this->text->value(), FILTER_VALIDATE_URL) !== false;
    }
}
