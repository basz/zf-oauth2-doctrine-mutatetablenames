Mutate tablename for Apigility OAuth2 Doctrine Adapter
======================================================

About
-----

This module allows to configure the tables that the [OAuth2 Doctrine Adapter](https://github.com/api-skeletons/zf-oauth2-doctrine) for [Apigility](https://apigility.org) generates.

[![Latest Stable Version](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/v/stable.svg)](https://packagist.org/packages/bushbaby/slmqueuedoctrine-postponablejobstrategy)
[![Total Downloads](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/downloads.svg)](https://packagist.org/packages/bushbaby/slmqueuedoctrine-postponablejobstrategy)
[![Latest Unstable Version](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/v/unstable.svg)](https://packagist.org/packages/bushbaby/slmqueuedoctrine-postponablejobstrategy)
[![Coverage Status](https://coveralls.io/repos/basz/zf-oauth2-doctrine-mutatetablenames/badge.png)](https://coveralls.io/r/basz/zf-oauth2-doctrine-mutatetablenames)
[![License](https://poser.pugx.org/bushbaby/zf-oauth2-doctrine-mutatetablenames/license.svg)](https://packagist.org/packages/bushbaby/slmqueuedoctrine-postponablejobstrategy)

Installation
------------

Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
$ php composer.phar require bushbaby/zf-oauth2-doctrine-mutatetablenames "~0.2"
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
