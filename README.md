Mutate tablename for Apigility/Laminas API Tools OAuth2 Doctrine Adapter
======================================================

About
-----

> ^1.0 This module allows to configure the tables that the [Fork OAuth2 Doctrine Adapter](https://github.com/samsonasik/zf-oauth2-doctrine) for [Laminas API Tools](https://api-tools.getlaminas.org/) generates.
> ^0.0 This module allows to configure the tables that the [OAuth2 Doctrine Adapter](https://github.com/api-skeletons/zf-oauth2-doctrine) for [Apigility](https://apigility.org) generates.

[![Latest Stable Version](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/v/stable)](https://packagist.org/packages/bushbaby/zf-oauth2-doctrine-mutatetablenames)
[![Total Downloads](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/downloads)](https://packagist.org/packages/bushbaby/zf-oauth2-doctrine-mutatetablenames)
[![Latest Unstable Version](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/v/unstable)](https://packagist.org/packages/bushbaby/zf-oauth2-doctrine-mutatetablenames)
[![Coverage Status](https://coveralls.io/repos/github/basz/zf-oauth2-doctrine-mutatetablenames/badge.svg?branch=master)](https://coveralls.io/github/basz/zf-oauth2-doctrine-mutatetablenames?branch=master)
[![License](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/license)](https://packagist.org/packages/bushbaby/zf-oauth2-doctrine-mutatetablenames)

Installation
------------

Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
$ composer require bushbaby/zf-oauth2-doctrine-mutatetablenames
```

Add this module to your application's configuration:

```php
'modules' => array(
   ...
   'ZF\OAuth2\Doctrine\MutateTableNames',
),
```


Configuration
-------------

Copy `config/oauth2.doctrine-orm.mutatetablenames.global.php.dist` to your autoload directory and rename to `oauth2.doctrine-orm.mutatetablenames.global.php`

Edit the appropriate values to customize table names. This module considers the usage of the configured doctrine event manager.


Migration
---------

You should be able to review the changes with the following command

```
php public/index.php orm:schema-tool:update --dump-sql
```

When satisfied run this command to actually modify your database

```
php public/index.php orm:schema-tool:update --force
```

Now you should manually copy the relevant information to the new tables. Old tables are not removed unless you specify the '--complete' flag.

*WARNING: Will find any difference between the doctrine managed entities and the schema found in the database, not just the ones regarding the table name changes!*
