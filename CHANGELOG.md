# Changelog

## [0.3.0] — 2025-11-07

### Added

- Func components:
    - `Func`, `FuncOf`, `FuncEnvelope`
    - `BiFunc`, `BiFuncOf`
    - `Proc`, `ProcOf`
    - `Predicate`, `PredicateOf`
    - `FuncWithFallback`
    - `Repeated`
    - `StickyFunc`

## [0.2.0] — 2025-11-07

### Added

- Scalar components:
    - `AndOf`, `OrOf`, `Not`, `XorOf`, `Ternary`, `Constant`, `Between`, `EqualTo`, `GreaterThan`, `LessThan`
- Text component: `TextOfScalar`
- Custom PHPUnit constraints:
    - `HasTextValue`, `HasBoolValue`, `HasScalarValue`, `HasScalarValues`, `Throws`, etc.

### Changed

- Downgraded PHP requirement to **8.2** (Dockerfile, composer.json, CI)
- Updated Rector config for PHP 8.2 compatibility