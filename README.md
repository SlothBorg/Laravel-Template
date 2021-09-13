
## About

### Built on:
  * [Laravel 8](https://laravel.com/docs/8.x/)
  * [Livewire](https://laravel-livewire.com/)
  * [Livewire Modal](https://github.com/livewire-ui/modal/)
  * [Laravel/jetstream](https://jetstream.laravel.com/2.x/introduction.html)
  * [Laravel Telescope](https://laravel.com/docs/8.x/telescope)
  * [laravel horizon](https://laravel.com/docs/8.x/horizon)
  * [Alpine.js](https://github.com/alpinejs/alpine/)
  * [Tailwind CSS](https://tailwindcss.com/)

```
composer require livewire/livewire
composer require livewire-ui/modal
# published so that the classes maybe added to get around tailwind purge
php artisan vendor:publish --tag=livewire-ui-modal-views

composer require laravel/jetstream
php artisan jetstream:install livewire
composer require laravel/horizon
php artisan horizon:install
composer require laravel/telescope --dev
php artisan telescope:install

npm install alpinejs
npm install tailwindcss
```

### Customizations
* added global `ddf()` and `ddq()` for easier debugging
* add tailwind max-width classes to `/resources/views/vendor/livewire-ui-modal/modal.blade.php` to ensure they are not purged by tailwind purge
* add Permissions and Roles
  ```
  art make:model role -crmf
  art make:model permission -crmf
  art make:migration create_users_roles_table
  art make:migration create_roles_permissions_table
  art make:migration create_users_permissions_table
  art make:migration add_soft_delete_to_users
  ```

## ToDo
* Build out user groups, roles, and permissions
* IMpliment [Telescope dashboard authorization](https://laravel.com/docs/8.x/telescope#dashboard-authorization)
* Add basic tests
  * unit
  * feature
  * Livewire
* Add some kind of admin panal: 
  * [Laravel Nova?](https://nova.laravel.com/)
  * [Sharp](https://github.com/code16/sharp)
  * [voyager](https://github.com/the-control-group/voyager)
  * other
* add markdown renddering and parsing
* add [HTML Purifier](http://htmlpurifier.org/)
* Add [Tags and Taggables](https://github.com/spatie/laravel-tags)
* Dockerize!
