#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/phpcs/phpcs.xml"

if [ ! -f "$CONFIG" ]; then
  echo "PHPCS config not found: $CONFIG"
  exit 1
fi

BIN="$(.sheriff/_composer.sh phpcs)"

exec .sheriff/_skip_if_empty.sh src '*.php' PHPCS -- \
  "$BIN" --standard="$CONFIG"
