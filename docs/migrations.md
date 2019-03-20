## Executing migrations

To execute the migrations run:

```
composer migrate
```

This will load all migrations in the ```docs/migrations``` folder and execute those that are not yet registered in the database table ```migrations```. This table will be created if it does not exist.

## Creating a migration

To create a new migration run:

```
composer migration
```

This will create a migration template file. The name will be a timestamp. The _migrate_ command will execute the function inside the file whose name is **identical** to the filename (without .php);

## Available functions inside the migration file

The migration files have access to the following files:

* ```.env```
* ```helpers/path.php```
* ```helpers/database.php```