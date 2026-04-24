#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/phpstan/phpstan.neon"

if [ ! -f "$CONFIG" ]; then
  echo "PHPStan config not found: $CONFIG"
  exit 1
fi

BIN="$(.piqule/_composer.sh phpstan)"

exec .piqule/_skip_if_empty.sh src '*.php' PHPStan -- \
  "$BIN" analyse \
  -c "$CONFIG" \
  --memory-limit=1G
