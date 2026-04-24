#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/jsonlint/config.json"

if [ ! -f "$CONFIG" ]; then
  echo "JSONLint config not found: $CONFIG"
  exit 1
fi

.piqule/_docker.sh jsonlint \
  -f "$CONFIG" \
  --quiet
