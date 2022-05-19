# Result

[![Continuous Integration](https://github.com/ghostwriter/result/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/ghostwriter/result/actions/workflows/continuous-integration.yml)
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
use Ghostwriter\Result\{ResultInterface, Success, Error};

// basic setting and getting of values
$greeting = new Success('Hello world!');
$name = new Error(new InvalidArgumentException());

echo $greeting->unwrap(); // echos 'Hello world!'

echo $name->unwrap(); // throws a ResultException
echo $name->unwrapOr('Anonymous'); // echos 'Anonymous'
echo $name->unwrapError(); // returns InvalidArgumentException

// function that returns a Result<number, string>
function divide(int $x, int $y): ResultInterface
{
    if ($y === 0) {
        return new Error(new DivisionByZeroError);
    }
    return new Success($x / $y);
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

[![ghostwriter's GitHub Sponsors](https://img.shields.io/github/sponsors/ghostwriter?label=Sponsors&logo=GitHub%20Sponsors)](https://github.com/sponsors/ghostwriter)

Maintaining open source software is a thankless, time-consuming job.

Sponsorships are one of the best ways to contribute to the long-term sustainability of an open-source licensed project.


Please consider giving back, to fund the continued development of `ghostwriter/result-type`, by sponsoring me here on GitHub.

[[Become a GitHub Sponsor](https://github.com/sponsors/ghostwriter)]

### For Developers

Please consider helping your company become a GitHub Sponsor, to support the open-source licensed project that runs your business.

## Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [All Contributors](https://github.com/ghostwriter/result/contributors)

## License

The BSD-3-Clause. Please see [License File](./LICENSE) for more information.
