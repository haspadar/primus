<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;
use Primus\Text\Text;

/**
 * Canonical Base64 textual representation of Bytes.
 *
 * Example:
 *     $text = new Base64Encoded(new BytesOf("hello"));
 *     $text->value(); // "aGVsbG8="
 */
final readonly class Base64Encoded implements Text
{
    /**
     * Ctor.
     *
     * @param Bytes $origin The bytes to encode.
     */
    public function __construct(private Bytes $origin) {}

    #[Override]
    public function value(): string
    {
        return base64_encode($this->origin->value());
    }
}
