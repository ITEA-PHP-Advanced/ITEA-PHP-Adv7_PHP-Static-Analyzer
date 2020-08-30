CHANGELOG for ITEA-PHP-Adv7_PHP-Static-Analyzer 
==========================

Changelog for v1.2.0
---------------------
Fix Code style.
PhpFileUtil.php had cyrillic character.
Change some internal command logic. 

Changelog for v1.1.0
---------------------

Add 2 new console command

```bash
list-classes
class-info
```

Usage
_____
Command `list-classes` list all available names of classes from php files at destination path.
```bash
$ console list-classes $path
```

Command `class-info` show short info about class. It includes counters for all types properties and methods.
```bash
$ console class-info $NAMECLASS
```

Command `class-info` have additional option --full for listing all properties and methods.
```bash
$ console class-info $NAMECLASS --full
```
