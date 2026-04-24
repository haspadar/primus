#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/phpunit/phpunit.xml"

if [ ! -f "$CONFIG" ]; then
  echo "PHPUnit config not found: $CONFIG" >&2
  exit 1
fi

SEED="${PHPUNIT_SEED:-}"

BIN="$(.piqule/_composer.sh phpunit)"

ARGS=(-c "$CONFIG" --order-by=random)

if [ -n "$SEED" ]; then
  case "$SEED" in
    (''|*[!0-9]*)
      echo "PHPUNIT_SEED must be a positive integer, got: $SEED" >&2
      exit 1
      ;;
  esac

  if [ "$SEED" -eq 0 ]; then
    echo "PHPUNIT_SEED must be greater than zero" >&2
    exit 1
  fi

  ARGS+=(--random-order-seed="$SEED")
fi

PHP_OPTIONS_STR="-d memory_limit=1G"
PHP_OPTIONS=()
if [ -n "$PHP_OPTIONS_STR" ]; then
  read -ra PHP_OPTIONS <<< "$PHP_OPTIONS_STR"
fi

PHP_OPTIONS_RC=0
PHP_OPTIONS_DIAG=$(php "${PHP_OPTIONS[@]+"${PHP_OPTIONS[@]}"}" -r 'exit(0);' 2>&1 >/dev/null) || PHP_OPTIONS_RC=$?
if [ "$PHP_OPTIONS_RC" -ne 0 ] || [ -n "$PHP_OPTIONS_DIAG" ]; then
  echo "Invalid phpunit.php_options: $PHP_OPTIONS_STR" >&2
  [ -n "$PHP_OPTIONS_DIAG" ] && printf '%s\n' "$PHP_OPTIONS_DIAG" >&2
  exit 1
fi

COVERAGE_FILE=".piqule/codecov/coverage.xml"

if php "${PHP_OPTIONS[@]+"${PHP_OPTIONS[@]}"}" -r 'exit(extension_loaded("xdebug") ? 0 : 1);' 2>/dev/null; then
  mkdir -p "$(dirname "$COVERAGE_FILE")"
  ARGS+=(--coverage-clover="$COVERAGE_FILE")
  XDEBUG_MODE=coverage
else
  XDEBUG_MODE=off
fi

export XDEBUG_MODE

exec .piqule/_skip_if_empty.sh tests '*Test.php' PHPUnit "PHP tests" -- \
  php "${PHP_OPTIONS[@]+"${PHP_OPTIONS[@]}"}" "$BIN" "${ARGS[@]}"
