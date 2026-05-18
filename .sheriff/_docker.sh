#!/usr/bin/env bash
set -euo pipefail

if ! command -v docker >/dev/null 2>&1; then
  echo "Error: docker is not installed or not in PATH" >&2
  exit 1
fi

PROJECT_ROOT="$(pwd)"
DEFAULT_IMAGE="ghcr.io/haspadar/sheriff-infra@sha256:e64d3f39bdd00e8734e2e4311a5be91b6365757dd7b5fe385451c71af4899147"
IMAGE="${SHERIFF_INFRA_IMAGE:-$DEFAULT_IMAGE}"

docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$PROJECT_ROOT:/project" \
  -w /project \
  "$IMAGE" \
  "$@"
