# Omnipay Payline

**[Payline](http://www.payline.com/index.php/en/) gateway for the Omnipay PHP payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ck-developer/omnipay-payline.svg?style=flat-square)](https://packagist.org/packages/ck-developer/omnipay-payline)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ck-developer/omnipay-payline/master.svg?style=flat-square)](https://travis-ci.org/ck-developer/omnipay-payline)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ck-developer/omnipay-payline.svg?style=flat-square)](https://scrutinizer-ci.com/g/ck-developer/omnipay-payline/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/ck-developer/omnipay-payline.svg?style=flat-square)](https://scrutinizer-ci.com/g/ck-developer/omnipay-payline)
[![Total Downloads](https://img.shields.io/packagist/dt/ck-developer/omnipay-payline.svg?style=flat-square)](https://packagist.org/packages/ck-developer/omnipay-payline)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements payline support for Omnipay.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require ck-developer/omnipay-payline
```

## Usage

The following gateways are provided by this package:

 * Payline_Web (Payline Web Payment API)
 * Payline_Direct (Payline Direct Payment API)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/ck-developer/omnipay-payline/issues),
or better yet, fork the library and submit a pull request.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email claude@khedhiri.com instead of using the issue tracker.

## Credits

- [Claude Khedhiri](https://github.com/ck-developer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
