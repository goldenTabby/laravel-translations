# Laravel Translation System
## Installation
### Publish migrations and config
```sh
php artisan vendor:publish
```
### Migrate tables to db
```sh
php artisan migrate
```
add
```sh
 Tabby\Translations\TranslationsServiceProvider::class
```
to config/app.php, at the end of 'providers' array
## Usage
Package comes with helper function.
Show translation
```sh
t('translation.key')
```
Show default
```sh
t('translation.key', 'Default value')
```
Show translation with dynamic parameters
```sh
t('translation.key', ['paramName' => 'paramValue'])
```
## License
MIT