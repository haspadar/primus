#!/usr/bin/env bash
set -euo pipefail

if ! command -v docker >/dev/null 2>&1; then
  echo "Error: docker is not installed or not in PATH" >&2
  exit 1
fi

PROJECT_ROOT="$(pwd)"
DEFAULT_IMAGE="ghcr.io/haspadar/sheriff-infra@sha256:3c15f3419f6e417c345fe22eded042146a11cdba4cd9032cdc4355f7036215d0"
IMAGE="${SHERIFF_INFRA_IMAGE:-$DEFAULT_IMAGE}"

docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$PROJECT_ROOT:/project" \
  -w /project \
  "$IMAGE" \
  "$@"
