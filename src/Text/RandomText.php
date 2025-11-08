<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Text;

use Primus\Scalar\ScalarOf;

/**
 * Randomly generated {@see Text}.
 *
 * Creates a text of a given length composed of characters
 * from the specified alphabet.
 *
 * Example:
 * $text = new RandomText(8);
 * echo $text->value(); // e.g. 'aZ8mKp2Q'
 *
 * @since 0.2
 */
final readonly class RandomText extends TextEnvelope
{
    public function __construct(int $length, string $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        $scalar = new ScalarOf(
            function () use ($length, $alphabet): string {
                $alphabet = $alphabet !== '' ? $alphabet : 'a';
                $size = mb_strlen($alphabet, 'UTF-8');
                $result = '';

                for ($i = 0; $i < max(0, $length); $i++) {
                    $result .= mb_substr($alphabet, random_int(0, $size - 1), 1, 'UTF-8');
                }

                return $result;
            }
        );

        parent::__construct(new TextOf($scalar->value()));
    }
}
