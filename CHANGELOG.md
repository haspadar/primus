# Changelog

## [0.5.0] – 2025-11-19

### Added

- Func constraints:
    - `AppliesFuncTo`
    - `EqualsValue`
    - `HasScalarValue`
    - (internal) unified helpers for function-related assertions

- Iterator components:
    - `IteratorOf`
    - `Filtered`
    - `Mapped`
    - `Joined`
    - `NoNulls`

- Iterable components:
    - `IterableOf`
    - `Filtered`
    - `Mapped`
    - `Joined`
    - `NoNulls`

- PHPUnit constraints for iterators:
    - `HasIteratorValues`
    - `HasKey`
    - `HasKeyValuePairs`

### Changed

- Updated all Func tests:
    - migrated to the new constraints
    - added explicit assertion messages
    - simplified test bodies and removed temporary counters/variables
    - unified assertion style across the test suite

- Iterator/Iterable wrappers now use lazy, on-demand iteration in line with Cactoos/EO design.
- Aligned docblocks across Iterator/Iterable components.

### Removed

- Deprecated `Sequence` abstraction, fully replaced by Iterator + Iterable components.
- Legacy `CallCounter` helper removed after migrating to constraint-based call tracking.

## [0.4.0] – 2025-11-14

### Changed

- Removed Primus\Exception in favor of SPL exceptions
- Updated Scalar::value() phpdoc to `@throws Throwable`
- Normalized, TrimmedRight etc. now throw InvalidArgumentException instead of Primus\Exception

### Removed

- Primus\Exception

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