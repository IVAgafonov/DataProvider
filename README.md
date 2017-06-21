# Data provider
Default sql data provider

[![Build Status](https://travis-ci.org/IVAgafonov/DataProvider.svg?branch=master)](https://travis-ci.org/IVAgafonov/DataProvider)

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
