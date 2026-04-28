<picture>
    <source media="(prefers-color-scheme: dark)" srcset="docs/primus-banner-light.svg">
    <source media="(prefers-color-scheme: light)" srcset="docs/primus-banner-dark.svg">
    <img alt="Primus logo" width="280" src="docs/primus-banner-light.svg">
</picture>
<br><br>

[![CI](https://github.com/haspadar/primus/actions/workflows/ci.yml/badge.svg)](https://github.com/haspadar/primus/actions/workflows/ci.yml)
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
| `array_map(fn, $a)` | `new Mapped($a, new FuncOf(fn))` |
| `array_filter($a, fn)` | `new Filtered($a, new PredicateOf(fn))` |

---

## 🧱 Modules

### **Text**
Trimmed, Lowered, Uppered, Sub, WithoutTags, Abbreviated, LengthOfText, TextOf, IsEmpty

### **Scalar**
ScalarOf, ScalarEnvelope, Constant, Sticky, Ternary, EqualTo, GreaterThan, LessThan, Between, And_, Or_, Xor_, Not

### **Func**
Func, FuncOf, FuncEnvelope, BiFunc, Proc, Predicate, StickyFunc, Repeated

### **Numeric (WIP)**
Positive, NonZero, Rounded

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
- Static analysis via [`haspadar/piqule`](https://github.com/haspadar/piqule) —
  a curated bundle of strict quality gates (PHPStan level 9 with custom rules,
  PHP-CS-Fixer, PHPMD, PHPMetrics, Infection).

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

Requires **PHP ≥ 8.2**

---

## 📄 License

[MIT](LICENSE)
