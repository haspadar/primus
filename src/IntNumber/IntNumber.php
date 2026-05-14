<?php

declare(strict_types=1);

namespace Primus\IntNumber;

use Primus\Number\Number;

/**
 * Marker for whole-number primitives.
 *
 * Inherits the int, float and text projections from {@see Number}. Implementations
 * back their projections with native PHP int arithmetic so the int projection
 * preserves precision beyond the float53 boundary.
 */
interface IntNumber extends Number {}
