PHP Static Analyzer
===================

Command line PHP analyzer.

Includes the following console commands:
- `classes-created-by` - Shows the information how many classes created developer with particular email.

- `class-info` - Shows the class name, type, count of public, protected and private class properties and methods of the particular class.

Installation
------------

TBD

Usage
-----

- `classes-created-by`

Register command in your code:
```
$application = new Application('PHP Static Analyzer', 'v1.0.0');
$command = new ClassesCreatedByDeveloperCommand(new ClassesCreatedByDeveloperAnalyzer());
$application->add($command);
$application->run();
```
Run the console command:
```
php path/to/application/file classes-created-by 'path/to/directory' developer@email.com
```

- `class-info`

Register command in your code:
```
$application = new Application('PHP Static Analyzer', 'v1.0.0');
$command = new ClassInfoCommand(new ClassInfoAnalyzer());
$application->add($command);
$application->run();
```
Run the console command:
```
php path/to/application/file class-info 'Name\Space\ClassName'
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
