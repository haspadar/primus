#!/usr/bin/env bash
set -euo pipefail

if ! command -v docker >/dev/null 2>&1; then
  echo "Error: docker is not installed or not in PATH" >&2
  exit 1
fi

PROJECT_ROOT="$(pwd)"
DEFAULT_IMAGE="ghcr.io/haspadar/sheriff-infra@sha256:88c76164614b7a8eaa26db74470966458389c237bbf2d6e819ac222cd2ac3762"
IMAGE="${SHERIFF_INFRA_IMAGE:-$DEFAULT_IMAGE}"

docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$PROJECT_ROOT:/project" \
  -w /project \
  "$IMAGE" \
  "$@"
