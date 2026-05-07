#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/phpmetrics/config.json"
VERIFY=".sheriff/phpmetrics/verify.php"
REPORT=".sheriff/phpmetrics/phpmetrics.json"

if [ ! -f "$CONFIG" ]; then
  echo "PHPMetrics config not found: $CONFIG"
  exit 1
fi

rm -f "$REPORT"

BIN="$(.sheriff/_composer.sh phpmetrics)"

.sheriff/_skip_if_empty.sh src '*.php' PHPMetrics -- \
  php -d error_reporting='E_ALL & ~E_DEPRECATED' \
  "$BIN" \
  --config="$CONFIG"

if [ -f "$VERIFY" ] && [ -f "$REPORT" ]; then
  php "$VERIFY"
fi
