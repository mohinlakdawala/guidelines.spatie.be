# Laravel & PHP Style Guide

- [About Laravel](#about-laravel)
- [Configuration](#configuration)
- [Artisan commands](#artisan-commands)
- [Routing and requests](#routing-and-requests)
- [Controllers](#controllers)
- [Views](#views)
- [Validation](#validation)
- [Blade Templates](#blade-templates)
- [Authorization](#authorization)
- [Translations](#translations)

## About Laravel

First and foremost, Laravel provides the most value when you write things the way Laravel intended you to write. If there's a documented way to achieve something, follow it. Whenever you do something differently, make sure you have a justification for *why* you didn't follow the defaults.

## Configuration

Configuration files must use kebab-case.

```
config/
  pdf-generator.php
```

Configuration keys must use snake_case.

```php
// config/pdf-generator.php
return [
    'chrome_path' => env('CHROME_PATH'),
];
```
### No env helper outside of configuration files.
Do **NOT** use the `env` helper outside of configuration files. Create a configuration value from the `env` variable like above. This is very important in order to cache the config files on production environment for the speed boost. See the below laravel documentation link for details. Caching the configuration file will not be possible of the `env` helper is used anywhere outside the config files.

[https://laravel.com/docs/5.5/configuration#configuration-caching](https://laravel.com/docs/5.5/configuration#configuration-caching)

## Eloquent

For all DB operations, use eloquent and relationships wherever possible. Avoid using `DB::table()` or queries directly. Eloquent models should have the relationships defined and should be used to fetch the related models instead of using DB joins.

Do **NOT** put soft deletes everywhere. Use only if absolutely necessary and only if there is a specific client requirement for this. Define proper cascades on the foreign key. Refer to the below tutorials on how to set up the foreign key relations so that when a row is deleted from a table, the foreign key gets deleted/updated as per the business logic.

[http://www.mysqltutorial.org/mysql-on-delete-cascade/](http://www.mysqltutorial.org/mysql-on-delete-cascade/)
[https://www.techonthenet.com/sql_server/foreign_keys/foreign_delete_null.php](https://www.techonthenet.com/sql_server/foreign_keys/foreign_delete_null.php)

This means, the migrations should have proper `ON DELETE` actions defined for all the foreign key relations.

### Eloquent collections and objects
Use eloquent collections and objects instead of converting to arrays and passing to views. Collections offer better syntax and some very helpful methods compared to arrays. Thoroughly understand all the methods available for a collections in Laravel. Refer to the below laravel documentation page for details.

[https://laravel.com/docs/5.5/collections#introduction](https://laravel.com/docs/5.5/collections#introduction)

## Mail

### Use mailables
Use the Laravel provided mailable class to trigger any email. Refer below documentation: [https://laravel.com/docs/5.5/mail#writing-mailables](https://laravel.com/docs/5.5/mail#writing-mailables)

### Queue emails
Laravel offers very good queue system out of the box, which you can get up and running with very minimal configuration. Use queues for Mails if sending out multiple emails. Use queues for reports etc.

## Artisan commands

The names given to artisan commands should all be kebab-cased.

```bash
# Good
php artisan delete-old-records

# Bad
php artisan deleteOldRecords
```

A command should always give some feedback on what the result is. Minimally you should let the `handle` method spit out a comment at the end indicating that all went well.

```php
// in a Command
public function handle()
{
    // do some work

    $this->comment('All ok!');
}
```

If possible use a descriptive success message eg. `Old records deleted`.

## Routing and requests

Public-facing urls must use kebab-case.

```
https://spatie.be/open-source
https://spatie.be/jobs/front-end-developer
```

Routes must be named and route names must use camelCase. 
Use the names to generate URL wherever necessary in the code - so that if we have to change the URL, we do not have to update the code.

```php
Route::get('open-source', 'OpenSourceController@index')->name('openSource');
```

```html
<a href="{{ route('openSource') }}">
    Open Source
</a>
```

Avoid using Route::resource(), it is better to define each route separately. This serves as a good documentation and allows better control on the routes.

```php
// Bad
Route::get('/sliders', 'SlidersController');

// Good
Route::get('/sliders', 'SlidersController@index')->name('admin.sliders.index');
Route::post('/sliders', 'SlidersController@store')->name('admin.sliders.store');
Route::get('/sliders/create', 'SlidersController@create')->name('admin.sliders.create');
Route::delete('/sliders/{slider}', 'SlidersController@destroy')->name('admin.sliders.destroy');
Route::put('/sliders/{slider}', 'SlidersController@update')->name('admin.sliders.update');
Route::get('/sliders/{slider}/edit', 'SlidersController@edit')->name('admin.sliders.edit');
```

All routes have an http verb, that's why we like to put the verb first when defining a route. It makes a group of routes very readble. Any other route options should come after it.

```php
// good: all http verbs come first
Route::get('/', 'HomeController@index')->name('home');
Route::get('open-source', 'OpenSourceController@index')->middleware('openSource');

// bad: http verbs not easily scannable
Route::name('home')->get('/', 'HomeController@index');
Route::middleware('openSource')->get('OpenSourceController@index');
```

### Requests

Use Laravel helper methods for `csrf_token()` and `method_field()` in a form instead of manually adding the input fields. Again, it is highly encouraged to thoroughly understand all the helper methods provided by Laravel as they become quite helpful in making the code more readable and concise. See below laravel documentation link.

[https://laravel.com/docs/5.5/helpers#method-csrf-field](https://laravel.com/docs/5.5/helpers#method-csrf-field)

[https://laravel.com/docs/5.5/helpers#method-method-field](https://laravel.com/docs/5.5/helpers#method-method-field)

[https://laravel.com/docs/5.5/helpers](https://laravel.com/docs/5.5/helpers)

### Authorization and validations

Laravel validations should be added to the request class instead of validating in the the controllers and the same applies for authorization checks, especially if the authorization logic is a bit complex. This would allow us to reuse the same logic elsewhere whenever needed.

>Quick tip: It is always better to grant authority based on permissions instead of checking for roles. This would allow for more flexibity if the permissions get updated at any point in the project. 

## Controllers

Controllers that control a resource must use the plural resource name.

```php
class PostsController
{
    // ...
}
```

Try to keep controllers simple and stick to the default CRUD keywords (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). Extract a new controller if you need other actions.

In the following example, we could have `PostsController@favorite`, and `PostsController@unfavorite`, or we could extract it to a seperate `FavoritePostsController`.

```php
class PostsController
{
    public function create()
    {
        // ...
    }
    
    // ...
    
    public function favorite(Post $post)
    {
        request()->user()->favorites()->attach($post);
        
        return response(null, 200);
    }

    public function unfavorite(Post $post)
    {
        request()->user()->favorites()->detach($post);
        
        return response(null, 200);
    }
}
```

Here we fall back to default CRUD words, `create` and `destroy`.

```php
class FavoritePostsController
{
    public function create(Post $post)
    {
        request()->user()->favorites()->attach($post);
        
        return response(null, 200);
    }

    public function destroy(Post $post)
    {
        request()->user()->favorites()->detach($post);
        
        return response(null, 200);
    }
}
```

## Views

View files must use camelCase.

```
resources/
  views/
    openSource.blade.php
```

```php
class OpenSourceController
{
    public function index() {
        return view('openSource');
    }
}
```

## Validation

All custom validation rules must use snake_case:

```php
Validator::extend('organisation_type', function ($attribute, $value) {
    return OrganisationType::isValid($value);
});
```

## Blade Templates

Indent using four spaces.

```html
<a href="/open-source">
    Open Source
</a>
```

Don't add spaces after control structures.

```html
@if($condition)
    Something
@endif
```

## Authorization

Policies must use camelCase.

```php
Gate::define('editPost', function ($user, $post) {
    return $user->id == $post->user_id;
});
```

```html
@can('editPost', $post)
    <a href="{{ route('posts.edit', $post) }}">
        Edit
    </a>
@endcan
```

Try to name abilities using default CRUD words. One exception: replace `show` with `view`. A server shows a resource, a user views it.

## Translations

Translations must be rendered with the `__` function. We prefer using this over `@lang` in Blade views because `__` can be used in both Blade views and regular PHP code. Here's an example:

```php
<h2>{{ __('newsletter.form.title') }}</h2>

{!! __('newsletter.form.description') !!}
```
