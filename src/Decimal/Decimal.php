<?php

declare(strict_types=1);

namespace Primus\Decimal;

use Primus\Number\Number;

/**
 * Marker for arbitrary-precision decimal primitives.
 *
 * Inherits the int, float and text projections from {@see Number}.
 * Implementations preserve the decimal representation through `asText`
 * without going through `(string)(float)` normalization, so values such
 * as `"100000000000000.000001"` keep their precision beyond what float
 * can encode.
 */
interface Decimal extends Number {}
