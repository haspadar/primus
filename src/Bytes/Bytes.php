<?php

declare(strict_types=1);

namespace Primus\Bytes;

/**
 * Represents a sequence of raw binary bytes.
 *
 * In PHP, a binary byte sequence is just a string; the contract makes
 * the binary intent explicit and composable.
 */
interface Bytes
{
    /**
     * Returns the raw binary byte sequence.
     */
    public function value(): string;
}
