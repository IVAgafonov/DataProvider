# Data provider
Default sql data provider

[![Latest Stable Version](https://poser.pugx.org/iagafonov/data-provider/v/stable)](https://packagist.org/packages/iagafonov/data-provider)
[![Build Status](https://travis-ci.org/IVAgafonov/DataProvider.svg?branch=master)](https://travis-ci.org/IVAgafonov/DataProvider)
[![Coverage Status](https://coveralls.io/repos/github/IVAgafonov/DataProvider/badge.svg?branch=master)](https://coveralls.io/github/IVAgafonov/DataProvider?branch=master)

### Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```
composer require iagafonov/data-provider
```

Use
```php
use \IVAgafonov\System\DataProvider;

$config = [
    'dbHost' => 'localhost',
    'dbName' => 'name',
    'dbUser' => 'user',
    'dbPass' => 'secret',
];

$dataProvider = new DataProvider($config);
```
