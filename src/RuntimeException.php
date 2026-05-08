<?php

declare(strict_types=1);

namespace Primus;

use RuntimeException as BaseRuntimeException;

/**
 * Marker exception thrown by Primus decorators when a runtime contract is broken.
 *
 * Every Primus runtime failure uses this single type so that consumers can
 * distinguish primus-originated failures from unrelated runtime exceptions
 * via a single catch clause. No per-failure subclasses are introduced.
 *
 * @since 0.3
 */
final class RuntimeException extends BaseRuntimeException {}
