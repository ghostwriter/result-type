# Result

[![GitHub Sponsors](https://img.shields.io/github/sponsors/ghostwriter?label=Sponsor+@ghostwriter/result&logo=GitHub+Sponsors)](https://github.com/sponsors/ghostwriter)
[![Automation](https://github.com/ghostwriter/result/actions/workflows/automation.yml/badge.svg)](https://github.com/ghostwriter/result/actions/workflows/automation.yml)
[![Supported PHP Version](https://badgen.net/packagist/php/ghostwriter/result?color=8892bf)](https://www.php.net/supported-versions)
[![Downloads](https://badgen.net/packagist/dt/ghostwriter/result?color=blue)](https://packagist.org/packages/ghostwriter/result)

Provides a **`Result`** type implementation for PHP using [`ghostwriter/option`](https://github.com/ghostwriter/option)

## Installation

You can install the package via composer:

``` bash
composer require ghostwriter/result
```

## Usage

```php
use Ghostwriter\Result\Failure;
use Ghostwriter\Result\Success;

// --- Success ---
$success = Success::new('Hello world!');
$success->get(); // 'Hello world!'

// --- Failure ---
$failure = Failure::new(new ExampleException());
$failure->get(); // throws: ResultException
$failure->getOr('Fallback'); // 'Fallback'
$failure->getError(); // returns: instance of ExampleException

// --- Example ---
function divide(int $x, int $y): ResultInterface
{
    if ($y === 0) {
        return Result::failure(new DivisionByZeroError);
    }

    return Result::success($x / $y);
}

divide(1, 0); // Error(DivisionByZeroError)
divide(1, 1); // Success(1)
```

### Credits

- [Nathanael Esayeas](https://github.com/ghostwriter)
- [All Contributors](https://github.com/ghostwriter/result/contributors)

### Changelog

Please see [CHANGELOG.md](./CHANGELOG.md) for more information on what has changed recently.

### License

Please see [LICENSE](./LICENSE) for more information on the license that applies to this project.

### Security

Please see [SECURITY.md](./SECURITY.md) for more information on security disclosure process.
