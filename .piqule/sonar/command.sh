#!/usr/bin/env bash
set -euo pipefail

CLOUD="true"
if [ "$CLOUD" = "1" ] || [ "$CLOUD" = "true" ] || [ "$CLOUD" = "yes" ] || [ "$CLOUD" = "on" ]; then
  printf '\033[33m[SKIP] SonarCloud automatic analysis — no local scanner needed\033[0m\n'
  exit 0
fi

PROPS=".piqule/sonar/sonar-project.properties"

if [ ! -f "$PROPS" ]; then
  echo "SonarCloud config not found: $PROPS" >&2
  exit 1
fi

if [ -z "${SONAR_TOKEN:-}" ]; then
  printf '\033[33m[TIP] Set SONAR_TOKEN to enable SonarCloud analysis\033[0m\n'
  printf '\033[33m      Get token at: https://sonarcloud.io/account/security\033[0m\n'
  printf '\033[33m      ● export SONAR_TOKEN=<your-token>     (bash/zsh)\033[0m\n'
  printf '\033[33m      ● set -Ux SONAR_TOKEN <your-token>    (fish)\033[0m\n'
  exit 0
fi

if ! command -v docker >/dev/null 2>&1; then
  echo "Error: docker is not installed or not in PATH" >&2
  exit 1
fi

COVERAGE_FILE=".piqule/codecov/coverage.xml"
if [ -f "$COVERAGE_FILE" ]; then
  ESCAPED_PWD=$(printf '%s' "$(pwd)" | sed 's/[&/\]/\\&/g')
  sed "s|${ESCAPED_PWD}/||g" "$COVERAGE_FILE" > "${COVERAGE_FILE}.tmp" \
    && mv "${COVERAGE_FILE}.tmp" "$COVERAGE_FILE"
else
  printf '\033[33m[TIP] Run piqule check phpunit first to include coverage in SonarCloud analysis\033[0m\n'
fi

PROJECT_ROOT="$(pwd)"
IMAGE="${PIQULE_INFRA_IMAGE:-ghcr.io/haspadar/piqule-infra@sha256:5dc15e7dba7dbb8ec6060d01e40858947dcaa902e5af8b64921beef3fe63611f}"

docker run --rm \
  --user "$(id -u):$(id -g)" \
  -e SONAR_TOKEN="$SONAR_TOKEN" \
  -e HOME=/tmp \
  -v "$PROJECT_ROOT:/project" \
  -w /project \
  "$IMAGE" \
  sonar-scanner -Dproject.settings="$PROPS" -Dsonar.qualitygate.wait=true
