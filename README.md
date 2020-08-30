PHP Static Analyzer
===================

TBD

Installation
------------

TBD

Usage
-----

TBD

__command:__ _classes-info_

To use this command just run:
```bash
$ ./bin/console classes-info "<class_full_name>"
```
This will return information about class:
```
Class: <class_name> is <class_type>
Properties:
    public: 1    //|\
    protected: 4 //| Quantity of properties
    private: 0   //|/
Methods:
    public: 1    //|\
    protected: 2 //| Quantity of methods
    private: 0   //|/
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
