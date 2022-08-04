# Result

[![Compliance](https://github.com/ghostwriter/result/actions/workflows/compliance.yml/badge.svg)](https://github.com/ghostwriter/result/actions/workflows/compliance.yml)
[![Supported PHP Version](https://badgen.net/packagist/php/ghostwriter/result?color=8892bf)](https://www.php.net/supported-versions)
[![Type Coverage](https://shepherd.dev/github/ghostwriter/result/coverage.svg)](https://shepherd.dev/github/ghostwriter/result)
[![Latest Version on Packagist](https://badgen.net/packagist/v/ghostwriter/result)](https://packagist.org/packages/ghostwriter/result)
[![Downloads](https://badgen.net/packagist/dt/ghostwriter/result?color=blue)](https://packagist.org/packages/ghostwriter/result)

Provides a **Result type** implementation for PHP

## Installation

You can install the package via composer:

``` bash
composer require ghostwriter/result
```

## Usage

```php
use Ghostwriter\Result\Error;
use Ghostwriter\Result\Success;

// --- Success ---
$success = Success::create('Hello world!');
$success->unwrap(); // 'Hello world!'

// --- Error ---
$error = Error::create(new ExampleException());
$error->unwrap(); // throws: ResultException
$error->unwrapOr('Fallback'); // 'Fallback'
$error->unwrapError(); // returns: instance of ExampleException

// --- Example ---
function divide(int $x, int $y): ResultInterface
{
    if ($y === 0) {
        return Error::create(new DivisionByZeroError);
    }

    return Success::create($x / $y);
}

divide(1, 0); // Error(DivisionByZeroError)
divide(1, 1); // Success(1)
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email `nathanael.esayeas@protonmail.com` instead of using the issue tracker.

## Sponsors

[[`Become a GitHub Sponsor`](https://github.com/sponsors/ghostwriter)]

## Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [All Contributors](https://github.com/ghostwriter/result/contributors)

## License

The BSD-3-Clause. Please see [License File](./LICENSE) for more information.
