#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/psalm/psalm.xml"

if [ ! -f "$CONFIG" ]; then
  echo "Psalm config not found: $CONFIG"
  exit 1
fi

BIN="$(.sheriff/_composer.sh psalm)"

exec .sheriff/_skip_if_empty.sh src '*.php' Psalm -- \
  "$BIN" \
  --root=. \
  --config="$CONFIG" \
  --no-cache
