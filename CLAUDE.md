# CLAUDE.md

Guidance for Claude Code and other AI agents working in this repository.

## Project overview

`axazara/php-cs` is a Composer package that provides a shared `php-cs-fixer` configuration for all Axa Zara PHP projects. It ships three classes (`Config`, `Finder`, `Rules`) and two rule-set files (`base_rules.php`, `risk_rules.php`) that other projects pull in as a dev dependency. The package is the single source of truth for PSR-12-based code style across the organisation.

## Tech stack

- PHP 7.4 or 8.x (^7.4 || ^8.0); CI runs on PHP 8.3
- `friendsofphp/php-cs-fixer` ^3.34 — the underlying formatter
- PHPUnit ^9/^10/^11 — unit tests
- PHPStan ^1.10 (level max) — static analysis
- Mockery ^1.6 — test doubles
- `insolita/unused-scanner` ^2.4 — dead-dependency detection

## Getting started

```bash
composer install
```

No `.env` file or database is required; this is a library-only package.

## Common commands

| Task | Command |
|---|---|
| Test | `composer test` |
| Lint check (dry-run) | `composer sniff` |
| Auto-format | `composer format` |
| Static analysis | `composer analyse` |
| Unused dependency scan | `composer unused` |

## Architecture

```
src/
  Config.php        — factory: creates a PhpCsFixer\Config wired with finder + rules
  Finder.php        — factory: wraps PhpCsFixer\Finder, scans *.php, ignores *.blade.php
  Rules.php         — merges base_rules + optional risk_rules, supports rule exclusion
  base_rules.php    — non-risky ruleset (PSR-12 + ~60 additional fixers)
  risk_rules.php    — opt-in risky fixers (enabled via $riskyAllowed flag)
tests/              — PHPUnit tests for Config, Finder, and Rules (one file per class)
```

Consumers install the package, copy the generated `.php-cs-fixer.dist.php` stub into their project root, adjust the `$routes` array, and run `php-cs-fixer` against it. Custom rules can be passed as overrides or exclusions at construction time.

## Conventions

- All source files use `declare(strict_types=1)`.
- The package applies its own ruleset to itself — run `composer sniff` before committing to catch style violations.
- PHPStan is configured at `level: max` covering `src/` only; analysis failures are non-blocking in CI (`continue-on-error: true`) but should still be investigated.
- PHPUnit is configured with `processIsolation=true`, randomised execution order, and strict stop-on-defect flags — tests must be fully isolated.
- Risky fixers are opt-in: pass `$riskyAllowed = true` to `Config::createWithFinder()` to enable `risk_rules.php`.
- Tags prefixed with `v` trigger an automated GitHub Release with generated release notes.

## Git Conventions

### 1. Branch names

Enforced regex (`branch_name_pattern`):
```
^(feature|fix|hotfix|chore|docs|refactor|test|ci|perf|build|style)/[a-z0-9._-]+$
```

- Lowercase only, kebab-case after the prefix, **max 50 characters** total.
- Use the full word `feature/` — **never** `feat/` (the short `feat` form is only for commit message types).
- Include the ticket id when relevant: `feature/AXA-123-add-stripe` (the ticket id is lowercased to satisfy the pattern — e.g. `feature/axa-123-add-stripe`).
- **Never** use a `claude/` prefix or any prefix outside the allowed set.
- `main`, `release`, `staging` are permanent protected branches — never push to them directly.
- If a branch is misnamed, rename it before pushing: `git branch -m <old> <new>`.

### 2. Commit messages
Enforced regex (`commit_message_pattern`), applied to **every** commit:
```
^(feat|fix|docs|style|refactor|perf|test|build|ci|chore|revert)(\([^)]+\))?!?: .+
```
- Lowercase type, optional scope in parens, optional `!` for breaking changes, subject after `: `.
- Subject starts with a lowercase letter and has no trailing period.
- Examples: `feat(checkout): add Apple Pay support`, `fix(api): handle expired tokens`, `chore(deps): bump axios from 1.7.2 to 1.15.2`, `refactor!: drop Node 18 support`.
- Do not rewrite Dependabot commits — `chore(deps): bump X from a to b` is already enforced via `.github/dependabot.yml`.

### 3. Files that are always rejected
Never stage or commit:
- `.env`, `.env.*` (only `.env.example` and `.env.sample` are allowed), `**/.env`, `**/.env.*`
- Private keys: `**/id_rsa{,.pub}`, `**/id_dsa`, `**/id_ecdsa`, `**/id_ed25519`, `**/.ssh/id_*`
- Credentials: `**/.aws/credentials`, `**/credentials.json`, `**/service-account.json`, `**/firebase-adminsdk-*.json`, `**/secrets.{yml,yaml}`
- Extensions: `*.pem`, `*.key`, `*.p12`, `*.pfx`, `*.jks`, `*.keystore`, `*.ppk`, `*.asc`, `*.gpg`
- Any file larger than 100 MB (use git LFS)
If a secret is needed, use `.env.example` for env vars and an external secret manager for credentials.

### Pull requests targeting `main`, `release`, `staging`
All three are protected — a PR is required (direct push blocked):
- 1 approval, all conversations resolved, **squash or rebase merge only** (linear history enforced — no merge commits).
- Commits must be GPG- or SSH-signed. Signing is required for `main` (`required-signatures-main` ruleset).
- The PR **title** becomes the squash commit message and must match the commit-message regex above (enforced on all three branches).

**Required workflows run on PRs whose base is `main` only** (not `release`/`staging`): `Branch naming convention`, `PR title — Conventional Commits`, and `PR size labeler`.
If a check shows `Waiting for workflow to run` for over a minute, the third-party action is likely missing from the enterprise allowlist.

When the branch-naming or PR-title check fails, the baseline bot auto-posts rename/title suggestions, following the enforced regex patterns.
If the bot's suggestions are incorrect, edit the PR title or branch name to match the required format.

### Pre-push checklist
Before running `git push`:
1. Branch name matches the regex.
2. Every commit in `origin/main..HEAD` matches the commit pattern (`git log --format=%s origin/main..HEAD`).
3. No staged file is in the blocked paths/extensions list.
4. Commits are signed if the target is `main`.

If any check fails, fix it locally rather than letting the server reject the push.
