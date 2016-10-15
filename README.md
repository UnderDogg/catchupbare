# Laravel Enterprise Starter Kit (LESK)


## Installing

### Acquire a copy
```
git clone https://github.com/sroutier/laravel-enterprise-starter-kit.git lesk
```

### Fetch dependencies

#### Composer
For a development environment use:
```
composer install
```

For a production environment use:
```
composer install --no-dev
```


#### Node.js
Fetch all dependencies for Node.js using *npm* by using the following command:

```
npm install
```


#### Create your *.env* file
Create a *.env* file from the *.env.example* supplied.

For a Development environment use:
```
cp .env.example-dev .env
```

For a other environments, such as QA and Production use:
```
cp .env.example-qa .env
```


### Basic configuration

#### Generate application key
Generate the unique application key:
````
./artisan key:generate
````

#### Grant permissions to some directories. 
Either grant permission to all staff, or just to the Web Server staff by making it a member of the group that owns these folders.
````
chmod -R ugo+rw storage/
chmod -R ugo+rw bootstrap/cache/
````



### Migration
After having configured your database settings, you will want to build the database.
 
To run the migration scripts run this command
 ```
 ./artisan migrate
 ```
 
 To seed the database run the command below, note that in the development environment a few extra staff and permissions
 are created.
 ```
 ./artisan db:seed
 ```

### First login and test
You should now be able to launch a Web browser and see your new Web application. To log in using the *root* account
the default password is *Password1*. Please change it ASAP.


### Walled garden.
To enable the optional walled garden mode simply set the *WALLED_GARDEN* variable to *true* in the *.env* file as shown 
below:
````
WALLED-GARDEN.ENABLED=true
````
By default the walled garden mode is set to off or false. When enabled all guest or un-authenticated staff will be
redirected to the login page.

### Themes
To change the default theme, set the *DEFAULT_THEME* variable in the *.env* file:
````
THEME.DEFAULT=red
````


```
gulp --production
```

## Tips

### Deploy to a sub-directory
If you plan to deploy the application in a sub-directory of a Web server, such as 
```http://my-domain.com/awesome-app``` instead of the root of the server as ```http://awesome-app.com```, 
you may want to tweak the ```.htaccess``` file that is provided by default under the ```public/``` directory.

Below are the 2 Apache configuration files required to configure LESK to run under the directory ```/lesk-sp```.

Here is a example of a modified ```.htaccess``` configuration file:
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Sets the base URL for per-directory rewrites
    RewriteBase /lesk-sp/

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```
**_Note_** the addition of the ```RewriteBase``` directive pointing to the directory of the application.

And here is the matching ```/etc/httpd/conf.d/lesk-sp.conf```:
```
Alias /lesk-sp /var/www/lesk-sp/public

<Directory "/var/www/lesk-sp/public">
  AllowOverride all
  Order allow,deny
  Allow from all
</Directory>
```

## Troubleshooting
Below are some troubleshooting tips that we have encountered and resolved:

### Blank page or HTTP 500 server error.
Check the laravel log file (```storage/logs/laravel.log```) file for hints. If nothing new was added to the file that is a good hint in 
itself. Next, check the Web server error log (```/var/log/httpd/error.log```) if you see a message such as this one:
> PHP Fatal error:  Uncaught exception 'UnexpectedValueException' with message 'The stream or 
> file "/.../.../storage/logs/laravel.log" could not be opened: failed to open stream: Permission 
> denied' in /.../.../vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php:97

Check the file permission on the laravel log file (```storage/logs/laravel.log```) it could be that the process 
running your Web server does not have ```write``` permission to it.
 
### Node.js

#### Old version
As pointed out by [thassan](https://github.com/thassan) in [Issue 6](https://github.com/sroutier/laravel-5.1-enterprise-starter-kit/issues/6), 
if you distribution or OS ships with an older version of Node.js the name of the executable may be 'nodejs'. In recent versions the name has 
been changed to 'node'. This will cause some Node.js packages to fail during the installation as they expect to find the 'node' executable. 
To resolve this issue you can either create a symbolic link from the 'nodejs' executable to 'node', or you may want to consider installing 
a more recent version of Node.js.
To create a symbolic link issue the command:
```
sudo ln -s /usr/bin/nodejs /usr/bin/node
```

#### ENOENT error
If the installation of Node.js packages fails with a 'ENOENT' error, you may need to create a empty file at the root of the project as 
explained on [Stack Overflow](http://stackoverflow.com/questions/17990647/npm-install-errors-with-error-enoent-chmod). 
To create the empty file run:
```
touch .npmignore
```

#### Hangs
If the installation of Node.js packages appears to hang, it may be due to a race condition that does not manifest itself when invoked
with the ``-ddd`` after having deleted the ``node_modules`` directory at the root of the project:
```
rm -rf node_modules
npm install -ddd
```

## Change log
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security
If you discover any security related issues, please email sroutier@gmail.com instead of using the issue tracker.

## Issues
For the list of all current and former/closed issues see the [github issue list](https://github.com/sroutier/laravel-5.1-enterprise-starter-kit/issues).
If you find a problem, please follow the same link and create an new issue, I will look at it and get back to you ASAP.

## Contributing
I would be glad to accept your contributions if you want to participate and share. Just follow GitHub's guide on how 
to [fork a repository](https://help.github.com/articles/fork-a-repo/). Clone your repository to your machine, make 
your change then create a pull request after submitting your change to your repository.

## Credits & inspirations
It goes without saying that none of this could have been done without the great [Laravel](http://laravel.com/) 
framework, a big thank you goes out to [Taylor Otwell](http://taylorotwell.com/) and the hundreds of volunteers 
of the Laravel & Open Source community.

I would like to thank [Jeffrey Way](https://twitter.com/jeffrey_way) for the excellent [Laracast](https://laracasts.com/)
 a never ending source of knowledge.

Additionally credit goes out to the authors of the various components and modules, noted in the sections above, used 
as part of this project. 
 
Finally I would like to point to a number of projects that served as inspiration and great source of learning material.
These projects are similar to the LESK, but did not fully cover the requirements that I had. You may want to
 have a look at them, here is the list:
 
* [yajra/laravel-admin-template](https://github.com/yajra/laravel-admin-template) Laravel 4.2 Bootstrap Admin Starter Template, with Oracle DB Support.
* [start-laravel/sb-admin-laravel-5](https://github.com/start-laravel/sb-admin-laravel-5) Starter template / theme for Laravel 5.
* [Zemke/starter-laravel-angular](https://github.com/Zemke/starter-laravel-angular) Laravel and AngularJS Starter Application Boilerplate featuring Laravel 5 and AngularJS 1.3.13.
* [mrakodol/Laravel-5-Bootstrap-3-Starter-Site](https://github.com/mrakodol/Laravel-5-Bootstrap-3-Starter-Site) Laravel Framework 5 Bootstrap 3 Starter Site is a basic application with news, photo and video galleries.                                                                                                                
* [todstoychev/Laravel5Starter](https://github.com/todstoychev/Laravel5Starter) A Laravel 5 starter project. It contains staff management with roles and basic admin panel with application settings.

### License
The LESK is open-sourced software licensed under the GNU General Public License Version 3 (GPLv3). 
Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/badge/packagist-v0.1.0-orange.svg
[ico-license]: https://img.shields.io/badge/licence-GPLv3-brightgreen.svg

[link-packagist]: https://packagist.org/packages/sroutier/laravel-enterprise-starter-kit

