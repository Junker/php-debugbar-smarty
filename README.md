# SmartyCollector
Smarty Collector for PHP DebugBar 

## Installation
The best way to install SmartyCollector is to use a [Composer](https://getcomposer.org/download):

    php composer.phar require junker/debugbar-smarty

## Examples

```php

$debugbar->addCollector(new Junker\DebugBar\Bridge\SmartyCollector($smarty));

```

