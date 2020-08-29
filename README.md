PHP Static Analyzer
===================

TBD

Installation
------------

TBD

Usage
-----
```bash
./bin/console classes-analize-structure "<ClassName>"
```
or
```bash
php bin/console classes-analize-structure "<ClassName>"
```
Examlle:
```bash
./bin/console classes-analize-structure "ITEA\PhpStaticAnalyzer\Command\TestClassForReflection"
```

Code style fixer
----------------

To check the code style just run the following command


```bash
$ composer cs-check
```


to fix the code style run next command

```bash
$ composer cs-fix
```

License
-------

[![license](https://img.shields.io/github/license/greeflas/default-project.svg)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2020, Volodymyr Kupriienko
