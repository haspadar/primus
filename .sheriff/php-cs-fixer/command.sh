#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/php-cs-fixer/php-cs-fixer.project.php"

if [ ! -f "$CONFIG" ]; then
  echo "PHP CS Fixer config not found: $CONFIG"
  exit 1
fi

BIN="$(.sheriff/_composer.sh php-cs-fixer)"

exec .sheriff/_skip_if_empty.sh src '*.php' "PHP CS Fixer" -- \
  "$BIN" fix \
  --config="$CONFIG" \
  --dry-run \
  --diff
