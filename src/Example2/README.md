# Introduction

The operations manager wants to keep track of the fuel levels in any given storage.

# Tasks

* Created storages from a file. File example:
  ```csv
  1,"Storage JET fuel",10000
  2,"Storage basic fuel",1000
  ```
* Add or remove fuel from storage.
* Print all storages fuel amount.
* Print all fillings for storage.
* Filter by storage.

# Usage  
  
### Syntax

`php storage.php [Arguments]...`

### Arguments

* `file` - storages configuration file path.
* `storage-id` - specifies storage on which the operations will be applied.
* `amount` - add or remove fuel from storage.
  
### Examples

* `php storage.php file=config.csv` - creates storages from config.csv file.
* `php storage.php storage-id=1 amount=10` - adds 10l fuel to storage with id 1.
* `php storage.php storage-id=2 amount=-20` - removes 20l fuel from storage with id 2.
* `php storage.php` - prints all information about fuel storages.
* `php storage.php storage-id=1` - prints all information for fuel storage with id 1.