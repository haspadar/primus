#!/usr/bin/env bash
set -euo pipefail

CONFIG=".piqule/typos/_typos.toml"

if [ ! -f "$CONFIG" ]; then
  echo "Typos config not found: $CONFIG"
  exit 1
fi

.piqule/_docker.sh typos \
  --config "$CONFIG"
