# Installation

Database creation

```sh
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

### Plugins

Code coverage

```sh
$ phpunit -c app/ --coverage-html code-coverage/
```