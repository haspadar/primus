#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/psalm/psalm.xml"

if [ ! -f "$CONFIG" ]; then
  echo "Psalm config not found: $CONFIG"
  exit 1
fi

BIN="$(.piqule/_composer.sh psalm)"

exec .piqule/_skip_if_empty.sh src '*.php' Psalm -- \
  "$BIN" \
  --root=. \
  --config="$CONFIG" \
  --no-cache
