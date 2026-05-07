#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/yamllint/.yamllint.yml"

if [ ! -f "$CONFIG" ]; then
  echo "Yamllint config not found: $CONFIG"
  exit 1
fi

.sheriff/_docker.sh yamllint \
  -c "$CONFIG" \
  .
