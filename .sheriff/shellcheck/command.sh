#!/usr/bin/env bash
set -euo pipefail

CONFIG=".sheriff/shellcheck/.shellcheckrc"

if [ ! -f "$CONFIG" ]; then
  echo "ShellCheck config not found: $CONFIG"
  exit 1
fi

# ============================================================
# Collect shell scripts (portable, NUL-safe, no git)
# ============================================================

FILES=()
while IFS= read -r -d '' file; do
  # Include .sh files and files with bash/sh shebang
  if [[ "$file" == *.sh ]] || \
     head -n1 "$file" | grep -qE '^#!.*[[:space:]/](bash|sh)([[:space:]]|$)'; then
    FILES+=("$file")
  fi
done < <(
  find . \
    -type f \
    ! -path "./vendor/*" \
    ! -path "./tests/*" \
    ! -path "./.git/*" \
    -print0
)

if [ ${#FILES[@]} -eq 0 ]; then
  echo "No shell scripts found"
  exit 0
fi

# ============================================================
# Run ShellCheck (docker)
# ============================================================

.sheriff/_docker.sh shellcheck \
  --rcfile "$CONFIG" \
  "${FILES[@]}"
