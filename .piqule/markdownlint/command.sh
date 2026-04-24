#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/markdownlint/.markdownlint-cli2.jsonc"

if [ ! -f "$CONFIG" ]; then
  echo "Markdownlint config not found: $CONFIG"
  exit 1
fi

.piqule/_docker.sh markdownlint-cli2 \
  --config "$CONFIG"
