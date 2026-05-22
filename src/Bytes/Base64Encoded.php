<?php

declare(strict_types=1);

namespace Primus\Bytes;

use Override;
use Primus\Text\Text;

/**
 * Canonical Base64 textual representation of Bytes.
 *
 * Construction forms:
 *
 * - `new Base64Encoded(Bytes)` — wrap an existing {@see Bytes} value.
 * - `Base64Encoded::of(Bytes)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $text = Base64Encoded::of(new BytesOf("hello"));
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

    /**
     * Encodes raw {@see Bytes} into a canonical Base64 representation.
     *
     * @param Bytes $bytes The bytes to encode.
     * @psalm-api
     */
    public static function of(Bytes $bytes): self
    {
        return new self($bytes);
    }

    #[Override]
    public function value(): string
    {
        return base64_encode($this->origin->value());
    }
}
