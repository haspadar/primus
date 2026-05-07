#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/typos/_typos.toml"

if [ ! -f "$CONFIG" ]; then
  echo "Typos config not found: $CONFIG"
  exit 1
fi

.sheriff/_docker.sh typos \
  --config "$CONFIG"
