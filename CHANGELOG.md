# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.4] - 2026-06-03

### Added

- `CHANGELOG.md` to track notable changes.

### Changed

- Migrated continuous integration from GitLab CI to GitHub Actions (#1).

### Fixed

- PHPUnit no longer reports "No tests executed" when running with `coverage: none`. The coverage report block in `phpunit.dist.xml` required a coverage driver; combined with `stopOnWarning`, the missing-driver warning aborted the run before any test executed. Coverage configuration has been removed from the default config so the suite runs in CI again.
- Corrected the PHPDoc types on `Rules::getRules()` and `Config::createWithFinder()` so PHPStan (level max) passes: rule values are `array|bool` and `$excludedRules` is a list of rule names.

## [0.3] - 2024-09-22

### Added

- Support for risky rules through the `riskyAllowed` flag in `Config::createWithFinder()`.

### Changed

- Enabled risky rules in the shipped configuration and refreshed `base_rules.php`.
- Strengthened strict-typing rules (`declare_strict_types`, `void_return`, `strict_param`).

## [0.2] - 2024-07-14

### Added

- Support for PHPUnit 9, 10 and 11.

### Changed

- Run CI against multiple PHP versions, including PHP 8.3.

## [0.1] - 2023-10-04

### Added

- Initial release: AxaZara PHP CS Fixer configuration based on PSR-12, with `Config`, `Finder` and `Rules` helpers and a distributable `.php-cs-fixer.dist.php`.

[Unreleased]: https://github.com/axazara/php-cs/compare/v0.4...HEAD
[0.4]: https://github.com/axazara/php-cs/compare/v0.3...v0.4
[0.3]: https://github.com/axazara/php-cs/compare/v0.2...v0.3
[0.2]: https://github.com/axazara/php-cs/compare/v0.1...v0.2
[0.1]: https://github.com/axazara/php-cs/releases/tag/v0.1
