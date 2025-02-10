# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com),
and this project adheres to [Semantic Versioning](https://semver.org).

## [2.0.0] - 2025-02-09

### Added

- Class `Ghostwriter\Result\Failure` has been added
- Class `Ghostwriter\Result\Interface\ExceptionInterface` has been added
- Class `Ghostwriter\Result\Interface\FailureInterface` has been added
- Class `Ghostwriter\Result\Interface\ResultInterface` has been added
- Class `Ghostwriter\Result\Interface\SuccessInterface` has been added

### Changed

- Parameter `$result` of `Ghostwriter\Result\Interface\ResultInterface::and()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Parameter `$result` of `Ghostwriter\Result\Interface\ResultInterface::or()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::and()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::andThen()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::map()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::mapError()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::or()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`
- Return type of `Ghostwriter\Result\Interface\ResultInterface::orElse()` changed from `Ghostwriter\Result\ResultInterface` to `Ghostwriter\Result\Interface\ResultInterface`

### Deprecated

-

### Removed

- Class `Ghostwriter\Result\AbstractResult` has been deleted
- Class `Ghostwriter\Result\ErrorInterface` has been deleted
- Class `Ghostwriter\Result\Error` has been deleted
- Class `Ghostwriter\Result\ExceptionInterface` has been deleted
- Class `Ghostwriter\Result\ResultInterface` has been deleted
- Class `Ghostwriter\Result\SuccessInterface` has been deleted
- Method `Ghostwriter\Result\Interface\ResultInterface::error()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::isError()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::isSuccess()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::success()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::unwrap()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::unwrapError()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::unwrapOr()` has been removed
- Method `Ghostwriter\Result\Interface\ResultInterface::unwrapOrElse()` has been removed
- Method `Ghostwriter\Result\Success::create()` has been removed
- 

### Fixed

-

### Security

-

[2.0.0]: https://github.com/ghostwriter/result/tag/2.0.0
