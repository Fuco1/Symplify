# One Controller for All Frameworks

[![Build Status](https://img.shields.io/travis/Symplify/SymbioticController.svg?style=flat-square)](https://travis-ci.org/Symplify/SymbioticController)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Symplify/SymbioticController.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/SymbioticController)
[![Downloads](https://img.shields.io/packagist/dt/symplify/symbiotic-controller.svg?style=flat-square)](https://packagist.org/packages/symplify/symbiotic-controller)


## Install

```sh
$ composer require symplify/symbiotic-controller
```


### Nette

Register the extension in `config.neon`:

```yaml
# app/config/config.neon

extensions:
    - Symplify\SymbioticController\Adapter\Nette\DI\SymbioticControllerExtension
```



That's all!


## Contributing

Send [issue](https://github.com/Symplify/Symplify/issues) or [pull-request](https://github.com/Symplify/Symplify/pulls) to main repository.
