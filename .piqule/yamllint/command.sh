#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/yamllint/.yamllint.yml"

if [ ! -f "$CONFIG" ]; then
  echo "Yamllint config not found: $CONFIG"
  exit 1
fi

.piqule/_docker.sh yamllint \
  -c "$CONFIG" \
  .
