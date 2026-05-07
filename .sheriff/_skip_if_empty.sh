#!/usr/bin/env bash
set -euo pipefail

DIR="${1:-}"
GLOB="${2:-}"
TOOL="${3:-}"

if [ -z "$DIR" ] || [ -z "$GLOB" ] || [ -z "$TOOL" ]; then
  echo "Usage: .sheriff/_skip_if_empty.sh <dir> <glob> <tool-name> [<kind>] -- <cmd> [args...]" >&2
  exit 2
fi

shift 3

KIND="PHP source files"
if [ $# -gt 0 ] && [ "$1" != "--" ]; then
  KIND="$1"
  shift
fi

if [ $# -eq 0 ] || [ "$1" != "--" ]; then
  echo "Usage: .sheriff/_skip_if_empty.sh <dir> <glob> <tool-name> [<kind>] -- <cmd> [args...]" >&2
  exit 2
fi
shift

if [ $# -eq 0 ]; then
  echo "Usage: .sheriff/_skip_if_empty.sh <dir> <glob> <tool-name> [<kind>] -- <cmd> [args...]" >&2
  exit 2
fi

if [ ! -d "$DIR" ] || [ -z "$(find "$DIR" -name "$GLOB" -print -quit)" ]; then
  echo "No $KIND found, skipping $TOOL"
  exit 0
fi

exec "$@"
