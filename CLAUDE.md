# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

OO PHP library published as `haspadar/primus` (namespace `Primus\`). It supports PHP
`~8.3.16 || ~8.4.3 || ~8.5.0`. Common procedural PHP operations are wrapped in small immutable
objects — `Trimmed`, `Lowered`, `Sub`, `Mapped`, `Filtered`, `Merged`, etc. Inspired by Elegant
Objects and cactoos. See `README.md` for philosophy and usage examples; this file covers only how
to work on the code.

## Design rules (enforced, not suggestions)

- `final` classes, `readonly` properties, immutable — composition over inheritance.
- No `null`, no `static`, no `isset`/`empty`, no procedural helpers, no mutable state.
  Enforced by `haspadar/psalm-eo-rules` via `.piqule/psalm/psalm.xml`.
- One class = one behavior. Constructor stores dependencies; a single method
  (`value()`, `asBool()`, `asInt()`…) computes the result.
- `declare(strict_types=1);` + PSR-12 formatting.

## Commands

| Task | Command |
| --- | --- |
| All configured quality checks | `vendor/bin/piqule check` |
| Auto-fix configured tools | `vendor/bin/piqule fix` |
| Single test class | `./vendor/bin/phpunit --filter <ClassName>` |
| Single test file | `./vendor/bin/phpunit tests/Text/TrimmedTest.php` |
| PHPUnit through Piqule | `vendor/bin/piqule check phpunit` |
| PHPStan level 9 | `vendor/bin/piqule check phpstan` |
| Psalm + EO rules | `vendor/bin/piqule check psalm` |
| PHP-CS-Fixer dry-run | `vendor/bin/piqule check php-cs-fixer` |
| PHP-CS-Fixer apply | `vendor/bin/piqule fix php-cs-fixer` |
| PHPCS | `vendor/bin/piqule check phpcs` |
| PHPMD | `vendor/bin/piqule check phpmd` |
| PHPMetrics | `vendor/bin/piqule check phpmetrics` |
| Infection | `vendor/bin/piqule check infection` |
| Infra lints | `vendor/bin/piqule check actionlint hadolint jsonlint markdownlint shellcheck typos yamllint` |

`XDEBUG_MODE=coverage` is already set inside coverage/infection scripts — do not add it manually.

## Piqule (tooling configuration)

Configs for PHPStan, Psalm, PHPUnit, PHPMD, PHP-CS-Fixer, Infection, PHPMetrics, plus lints
(yamllint, markdownlint, typos, hadolint, shellcheck, jsonlint) live in `.piqule/`, managed by
`haspadar/piqule` from `composer.lock`. Run tools through `vendor/bin/piqule check <tool>` rather
than invoking generated command scripts directly — this matches the project's pre-push hook and CI.

Pre-push hook `.git/hooks/pre-push` runs `composer exec -- piqule check`; if it fails, the push
is blocked.

## CI gates

`.github/workflows/piqule.yml` runs the Piqule checks on PHP 8.3. All of these are required on PRs:

- phpcs, phpstan, psalm, phpmd, phpmetrics (hard gate — regression in metrics fails the build)
- PHPUnit + Infection (mutation testing)
- yamllint, actionlint, markdownlint, typos, shellcheck, jsonlint, hadolint, php-cs-fixer

Additional gates:
- **PR size limit: 250 changed lines** (job `PR Size` in `.github/workflows/piqule.yml`). Split
  larger work into multiple PRs.
- **Exactly one release label** via `.github/workflows/require-pr-label.yml` unless the PR has
  `skip-changelog`.
- Release Drafter runs on merges to `main`.
- Coverage → Codecov; mutation stats → Stryker Dashboard.

## Suppression policy

Do not add `@phpstan-ignore`, `@phpstan-ignore-next-line`, `@psalm-suppress`, `// NOSONAR`,
baselines, or equivalents without explicit user approval. Investigate and fix the root cause
first.

## Release notes

Release notes are generated from PR labels by `release-drafter` (see
`.github/release-drafter.yml`). Each PR must carry exactly one of:
`feat`, `fix`, `refactor`, `docs`, `ci`, `chore`, `test`, `dependencies`. Use
`skip-changelog` to omit a PR from notes. There is no hand-maintained changelog.

<!-- piqule:begin -->
## Piqule

Quality tooling is managed by [piqule](https://github.com/haspadar/piqule). Run `vendor/bin/piqule check` before commits and `vendor/bin/piqule fix` for auto-fixes. Do not edit generated files in `.piqule/` and `.github/workflows/`. Rules live in `vendor/haspadar/piqule/DEV.md`.
<!-- piqule:end -->
