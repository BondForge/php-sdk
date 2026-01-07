# Contributing to BondForge SDKs

First off — thank you for your interest in contributing to BondForge.  
We genuinely appreciate bug reports, fixes, documentation improvements, and thoughtful discussions.

BondForge SDKs are intentionally designed to be **boring, predictable, and reliable**. Contributions should reinforce those qualities.

---

## Scope of These Repositories

These repositories contain **SDKs for interacting with the BondForge API**.

They are:
- client libraries
- integration tooling
- developer-facing infrastructure

They are **not**:
- the BondForge Core application
- a place for product feature requests unrelated to API usage
- experimental playgrounds

If you’re unsure whether something belongs here, open an issue and ask.

---

## Code of Conduct

Be respectful.  
Assume good intent.  
Disagree professionally.

We will not tolerate harassment, discrimination, or hostile behavior.  
Contributors who cannot engage constructively may be asked to leave.

---

## How to Contribute

### Reporting Bugs
When reporting a bug, please include:
- SDK language and version
- relevant code snippet (redact secrets)
- expected behavior
- actual behavior
- error messages or stack traces (if applicable)

Clear bug reports get fixed faster.

---

### Feature Requests
SDK feature requests should:
- align with existing API capabilities
- improve developer experience
- not introduce unnecessary abstractions

If a feature belongs in the **API itself**, it should be discussed in the BondForge Core repository instead.

---

### Pull Requests

We welcome pull requests that:
- fix bugs
- improve reliability
- clarify documentation
- improve consistency across SDKs

Before submitting a PR:
- fork the repository
- create a feature or fix branch
- ensure tests pass
- ensure formatting/linting passes
- keep changes focused and scoped

---

## Generated Code vs Hand-Written Code

Many SDKs include **generated code** derived from the OpenAPI specification.

**Please do not modify generated files directly.**

Generated code is typically located under:
- `generated/`
- `Generated/`
- similarly named namespaces or folders

Hand-written code (facades, helpers, error handling, pagination) lives outside those areas and is the correct place for most contributions.

If a change is required in generated code, open an issue describing the need so it can be addressed at the generation layer.

---

## Style & Philosophy

BondForge SDKs prioritize:
- clarity over cleverness
- explicit behavior over magic
- long-lived decisions over short-term convenience

We care less about how many languages we support and more about how long each decision has to live.

Please keep changes:
- readable
- well-scoped
- consistent with existing patterns

---

## Tests

All contributions should include or update tests where applicable.

Tests should:
- not depend on live API access
- be deterministic
- validate behavior, not implementation details

---

## License & Legal

By contributing to this repository, you agree that your contributions will be licensed under the **Apache License, Version 2.0**.

You also affirm that:
- you have the right to submit the work
- your contribution does not knowingly infringe on third-party rights

This keeps things clean and unambiguous for everyone.

---

## Questions?

If you have questions:
- open an issue
- start a discussion
- or ask for clarification before writing code

We’re happy to help — and we appreciate the time and care you put into contributing.

---

Thanks for helping make BondForge better.
