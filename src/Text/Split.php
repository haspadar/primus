<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\Scalar;

/**
 * {@see Text} split by a delimiter into parts.
 *
 * Produces an iterable of {@see Text} segments separated by the given delimiter.
 *
 * Example:
 *     $parts = new Split(',', new TextOf('a,b,c'));
 *     foreach ($parts->value() as $text) {
 *         echo $text->value(); // a, b, c
 *     }
 *
 * @implements Scalar<iterable<Text>>
 * @since 0.2
 */
final readonly class Split implements Scalar
{
    /**
     * @param non-empty-string $delimiter
     */
    public function __construct(
        private string $delimiter,
        private Text $origin,
    ) {
    }

    /**
     * @return iterable<Text>
     */
    #[\Override]
    public function value(): iterable
    {
        foreach (explode($this->delimiter, $this->origin->value()) as $part) {
            yield new TextOf($part);
        }
    }
}
