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
[![Psalm](https://img.shields.io/badge/psalm-level%208-brightgreen)](https://psalm.dev)
[![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/haspadar/primus?utm_source=oss&utm_medium=github&utm_campaign=haspadar%2Fprimus&labelColor=171717&color=FF570A&label=CodeRabbit+Reviews)](https://coderabbit.ai)
---

## 📦 About

**Primus** is a library of immutable value objects that wrap primitive types like `string`, `int`, `bool`, and `array`.

Instead of passing around loose values, you use small, self-contained wrappers like:

- `Lowered`, `Trimmed`, `Sub` (strings)
- `Yes`, `No`, `IsEmpty`, `IsEmail`, `IsUuid`, `LogicEnvelope` (logic)
- `Mapped`, `SequenceOf` (collections)

Each class encapsulates one behavior and can be composed with others to form robust, intention-revealing objects.

---

## 🧠 Philosophy

- ❌ No `null`, `static`, or shared state in the public API
- ✅ One object = one responsibility
- ✅ Final classes, immutability by default
- ✅ Composition over inheritance
- ✅ Behavior and data live together

Inspired by [Elegant Objects](https://www.yegor256.com/elegant-objects.html) and [cactoos](https://github.com/yegor256/cactoos).

---

## ✨ Example

```php
$text = new Sub(
    new Lowered(
        new Trimmed("  Hello, world!  ")
    ),
    5
);

echo $text->value(); // "hello"
```

Each wrapper adds one behavior:

- `Trimmed` removes whitespace
- `TruncatedRight` shortens the string

All wrappers implement the same interface and can be freely composed.

---

## 🧱 Modules

- **Text** — `Trimmed`, `Uppered`, `Lowered`, `Sub`, `WithoutTags`, `LengthOfText`, `Abbreviated`, `TextOf`
- **Logic** — `Yes`, `No`, `ThrowsIf`, `IsEmpty`, `IsEmail`, `IsUuid`, `LogicEnvelope`
- **Iterable** — `Sequence`, `SequenceOf`, `Mapped`, `Filtered`
- **Func** — `Func`, `FuncOf`, `Retry`, `Repeated`
- **Number** — *(coming soon)* `Positive`, `NonZero`, `Rounded`, etc.

---

## 🧩 Static Analysis Rules

Primus enforces [Elegant Objects](https://www.yegor256.com/elegant-objects.html) design principles using  
[`haspadar/psalm-eo-rules`](https://github.com/haspadar/psalm-eo-rules) — a custom Psalm plugin that forbids:

- `static` methods and properties
- `null`, `isset()`, and `empty()`
- non-`readonly` mutable state
- traits and inheritance misuse

These checks guarantee immutability and strict object boundaries across all modules.

---

## 📥 Installation

```bash
composer require haspadar/primus
```

Requires PHP 8.2

---

## 📄 License

[MIT](LICENSE)
