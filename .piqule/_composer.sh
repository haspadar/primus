#!/usr/bin/env bash
set -euo pipefail

BIN="${1:-}"
if [ -z "$BIN" ]; then
  echo "Usage: .piqule/_composer.sh <bin>"
  exit 1
fi

BIN_PATH="vendor/bin/$BIN"

if [ ! -f "vendor/autoload.php" ]; then
  echo "vendor not found"
  echo "Run: composer install"
  exit 1
fi

if [ ! -f "$BIN_PATH" ]; then
  echo "$BIN_PATH not found"
  echo "Run: composer install"
  exit 1
fi

echo "$BIN_PATH"