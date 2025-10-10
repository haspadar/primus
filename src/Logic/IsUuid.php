<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Logic;

/**
 * {@see Logic} that returns true if the text is a valid UUID v1–v5.
 *
 * Matches 8-4-4-4-12 pattern with correct version and variant bits.
 *
 * @psalm-pure
 */
final readonly class IsUuid extends LogicEnvelope
{
    #[\Override]
    public function value(): bool
    {
        return preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $this->text->value()
        ) === 1;
    }
}
