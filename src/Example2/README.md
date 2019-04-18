# Tasks

* Ability to see the current amount of fuel in the given storage.  
  Storages should be configurable from a file. The configuration file should contain storage **id**, **name** and **capacity** e.g.:  
  `php storage.php ${STORAGE_ID}` should print `${STORAGE_NAME}: 500l / 10000l`.  
  
  > Assuming that 500l are filled into the storage of 10000l capacity.