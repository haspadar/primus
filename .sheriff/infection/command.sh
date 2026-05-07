#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/infection/infection.json5"

if [ ! -f "$CONFIG" ]; then
  echo "Infection config not found: $CONFIG"
  exit 1
fi

INFECTION_BIN="$(.sheriff/_composer.sh infection)"

PHP_OPTIONS_STR="-d memory_limit=1G"
PHP_OPTIONS=()
if [ -n "$PHP_OPTIONS_STR" ]; then
  read -ra PHP_OPTIONS <<< "$PHP_OPTIONS_STR"
fi

PHP_OPTIONS_RC=0
PHP_OPTIONS_DIAG=$(php "${PHP_OPTIONS[@]+"${PHP_OPTIONS[@]}"}" -r 'exit(0);' 2>&1 >/dev/null) || PHP_OPTIONS_RC=$?
if [ "$PHP_OPTIONS_RC" -ne 0 ] || [ -n "$PHP_OPTIONS_DIAG" ]; then
  echo "Invalid infection.php_options: $PHP_OPTIONS_STR" >&2
  [ -n "$PHP_OPTIONS_DIAG" ] && printf '%s\n' "$PHP_OPTIONS_DIAG" >&2
  exit 1
fi

exec .sheriff/_skip_if_empty.sh src '*.php' Infection -- \
  env XDEBUG_MODE=coverage \
  php "${PHP_OPTIONS[@]+"${PHP_OPTIONS[@]}"}" \
  "$INFECTION_BIN" \
  --configuration="$CONFIG" \
  --threads=max
