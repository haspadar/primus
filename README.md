<picture>
    <source media="(prefers-color-scheme: dark)" srcset="assets/primus-banner-light.svg">
    <source media="(prefers-color-scheme: light)" srcset="assets/primus-banner-dark.svg">
    <img alt="Primus logo" width="280" src="assets/primus-banner-light.svg">
</picture>
<br><br>

[![CI](https://github.com/haspadar/primus/actions/workflows/sheriff.yml/badge.svg)](https://github.com/haspadar/primus/actions/workflows/sheriff.yml)
[![Coverage](https://codecov.io/gh/haspadar/primus/branch/main/graph/badge.svg)](https://codecov.io/gh/haspadar/primus)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fhaspadar%2Fprimus%2Fmain)](https://dashboard.stryker-mutator.io/reports/github.com/haspadar/primus/main)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%209-brightgreen)](https://phpstan.org/)

[![Hits-of-Code](https://hitsofcode.com/github/haspadar/primus?branch=main)](https://hitsofcode.com/github/haspadar/primus/view?branch=main)
[![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/haspadar/primus?labelColor=171717&color=FF570A&label=CodeRabbit+Reviews)](https://coderabbit.ai)

---

# Object‑Oriented PHP Primitives  

Primus is a library of object‑oriented PHP primitives.  
It provides common operations as small composable objects instead of functions.

Inspired by **Elegant Objects** and **cactoos**.

---

## 📦 Core Idea

Procedural PHP:

```php
strtolower(trim(substr($s, 0, 5)));
```

Primus:

```php
(new Sub(
    new Lowered(
        new Trimmed($s)
    ),
    5
))->value();
```

Each object represents exactly one operation.  
Objects are immutable, final, and easy to combine.

---

## 🧭 Quick Reference

| Procedural | Primus |
|-----------|--------|
| `trim($s)` | `new Trimmed($s)` |
| `strtolower($s)` | `new Lowered($s)` |
| `substr($s, 0, 5)` | `new Sub($s, 5)` |
| `strip_tags($s)` | `new WithoutTags($s)` |
| `strlen($s)` | `new LengthOfText($s)` |
| `array_map(fn, $a)` | `new Mapped(new MapOf($a), new FuncOf(fn))` |
| key-aware value mapping | `new BiMapped(new MapOf($a), new BiFuncOf(fn))` |
| `array_filter($a, fn)` | `new Filtered(new MapOf($a), new PredicateOf(fn))` |
| key-aware pair filtering | `new BiFiltered(new MapOf($a), new BiFuncOf(fn))` |
| `array_merge($a, $b)` | `new Merged(new MapOf($a), new MapOf($b))` |
| `array_merge` for lists | `new Joined(new ListOf(...$a), new ListOf(...$b))` |
| `array_keys($a)` | `new Keys(new MapOf($a))` |
| `array_values($a)` | `new Values(new MapOf($a))` |

---

## 🧱 Modules

### **Text**
Abbreviated, Capitalized, HtmlEscaped, IsEmpty, Joined, LeftPadded,
LengthOfText, Lowered, Normalized, RandomText, Repeated, Replaced,
RightPadded, Split, Sub, Text, TextEnvelope, TextOf, TextOfScalar, Trimmed,
TrimmedLeft, TrimmedRight, Uppered, WithoutTags

### **Scalar**
And_, Between, Constant, EqualTo, GreaterThan, LessThan, Not, Or_, Scalar,
ScalarEnvelope, ScalarOf, Sticky, Ternary, Xor_

### **Func**
BiFunc, BiFuncOf, BiProc, BiProcOf, Func, FuncEnvelope, FuncOf,
FuncWithFallback, Predicate, PredicateOf, Proc, ProcOf, Repeated, StickyFunc

### **List**
List_, ListEnvelope, ListOf, Filtered, Joined, Mapped, NoNulls, Reversed

### **Map**
Map, MapEnvelope, MapOf, BiFiltered, BiMapped, Filtered, Keys, Mapped, Merged, NoNulls, Values

### **Numeric**
Number

---

## 🧠 Design Principles

- No `null`  
- No `static`  
- No procedural helpers  
- No mutable state  

- Immutable objects  
- Final classes  
- One class = one behavior  
- Composition over inheritance  

---

## 🧪 Testing & Static Analysis

Primus includes:

- Custom PHPUnit constraints (`HasIteratorValues`, `EqualsValue`, …)
- Mutation testing (Infection)
- Static analysis via [`haspadar/sheriff`](https://github.com/haspadar/sheriff) —
  a curated bundle of strict quality gates (PHPStan level 9, Psalm with custom
  EO rules, PHP-CS-Fixer, PHPMD, PHPMetrics, Infection, and repository lints).

The enforced rules include:

- No `static`
- No `null`
- No `isset()` / `empty()`
- All state must be `readonly`
- No traits or unnecessary inheritance

---

## 📥 Installation

```bash
composer require haspadar/primus
```

Requires **PHP 8.3.16+**, **PHP 8.4.3+**, or **PHP 8.5+**.

---

## 📄 License

[MIT](LICENSE)
