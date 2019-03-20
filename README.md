# Viggen PHP Framework

Viggen is a starting point for simple PHP applications. It is primarily about the file-structure, but also includes a variety of tools in form of helpers. Its functionality is centered around the Klein.php, Idiorm and Paris libraries.

# Installation

Pre-requisites for this project are:

* PHP and Composer

When you have these fulfilled these requirements, you can install the project in three steps:

1. Clone this repository: ```git clone https://github.com/RalphvK/viggen.git```

2. Run ```composer install``` to install the various dependencies.

3. Next, configure the application by replacing the default values in ```.env.example.php``` and renaming this file to ```.env.php```.

# Migrations

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