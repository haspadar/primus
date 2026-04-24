#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/php-cs-fixer/php-cs-fixer.project.php"

if [ ! -f "$CONFIG" ]; then
  echo "PHP CS Fixer config not found: $CONFIG"
  exit 1
fi

BIN="$(.piqule/_composer.sh php-cs-fixer)"

exec .piqule/_skip_if_empty.sh src '*.php' "PHP CS Fixer" -- \
  "$BIN" fix \
  --config="$CONFIG" \
  --dry-run \
  --diff
