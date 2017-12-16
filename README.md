# Api wars

Laravel and Vue.js experiment with consuming Api, and voting

### Prerequisites

To run this app you need PHP and MySql (or MariaDB) installed on your computer. You also need php to run from your terminal. 

To test, open terminal window and type 

```
php -v
``` 

If you see a Php version information, you can procede with installing the project

### Installing

First, clone this repo and open terminal, run these commands:

```
cd apiwars
composer install
cp .example.env .env
php artisan key:generate
```

Now go to the .env config file, and put inside your MySQL credentials, and the database you will like to use for this app.

Then go back to terminal and continue:

```
php artisan migrate
php artisan db:seed --class=ApiEndpoints
php -S localhost:8000 -t /public
```

Now, your app should be running on localhost:8000 port.

You will need to cache the Api's by visiting [localhost:8000/cache](localhost:8000/cache).
Caching takes a while till all the Apis are cached in database, so wait till it tells you its cached.

After Apis are cached, you can visit  [localhost:8000/](localhost:8000/) and start the game :)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
