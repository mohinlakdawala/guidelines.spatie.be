# PHP Style Guide

## Coding standards

Code style must follow [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/). Generally speaking, everything string-like that's not public-facing should use camelCase. Detailed examples on these are spread throughout the guide in their relevant sections.

The variable names should be meaningful and as descriptive as possible.

```php
// Good
$totalHoursForTheDay, $clockedInUsers, 

// Bad
$a, $tot, $ciUsers
```

## No unused variables, unnecessary methods, commented code
The code should be free from unused variables, unnecessary methods or blocks of commented code. If it is a possibility that the code might have to be reverted to the previous one, the git history or git rollback should be used instead of relying on the commented code.

##  Strict equality checking
Strict comparison operator, which is, `===` should be used wherever possible instead of the loose comparison operator `==` as it can lead to some untraceable bugs in some cases. Details on this topic can be found on below link.

[https://www.codeproject.com/tips/819645/pitfalls-of-phps-comparison-operators-when-to-us](https://www.codeproject.com/tips/819645/pitfalls-of-phps-comparison-operators-when-to-us).

## Simplify conditional checks
Extract complex checks to functions on relevant object. In the below example, as you might see, the condition to check whether the exception has occurred due to a lost connection has been extracted in a separate function of its own which is then used to check for the condition wherever required. This makes the code more readable and allows a possibility to reuse the check in other places.
```php
protected function tryAgainIfCausedByLostConnection(Exception $e, $dsn, $username, $password, $options)
{
    if ($this->causedByLostConnection($e)) {
        return $this->createPdoConnection($dsn, $username, $password, $options);
    }

    throw $e;
}

protected function causedByLostConnection(Exception $e)
{
    $message = $e->getMessage();

    return Str::contains($message, [
        'server has gone away',
        'no connection to the server',
        'Lost connection',
        'is dead or not enabled',
        'Error while sending',
        'decryption failed or bad record mac',
    ]);
}
```

Some really useful tips on cleaning up the conditionals and to make them more readable and descriptive can be found below:

![Clean up conditionals](https://pbs.twimg.com/media/DNEilrlUIAAHtga.png)

## PHP7 features
Start using the new features that were introduced with PHP7, especially the scalar type hints which can help in making the code more readable and more documented. The following article explains this and the rests of the new features in depth.

Overview: [http://blog.teamtreehouse.com/5-new-features-php-7](http://blog.teamtreehouse.com/5-new-features-php-7).

In-depth video tutorials, [https://laracasts.com/series/php7-up-and-running](https://laracasts.com/series/php7-up-and-running)

## Docblocks

Don't use docblocks for methods that can be fully type hinted (unless you need a description).

Only add a description when it provides more context than the method signature itself. Use full sentences for descriptions, including a period at the end.

```php
// Good
class Url
{
    public static function fromString(string $url): Url
    {
        // ...
    }
}

// Bad: The description is redundant, and the method is fully type-hinted.
class Url
{
    /**
     * Create a url from a string.
     * 
     * @param string $url
     * 
     * @return \Spatie\Url\Url
     */
    public static function fromString(string $url): Url
    {
        // ...
    }
}
```

Always use fully qualified class names in docblocks.

```php
// Good

/**
 * @param string $url
 *
 * @return \Spatie\Url\Url
 */

// Bad

/**
 * @param string $foo
 *
 * @return Url
 */
```

## Ternary operators

Every portion of a ternary expression should be on it's own line unless it's a really short expression.

```php
// Good
$result = $object instanceof Model
    ? $object->name
    : 'A default value';

$name = $isFoo ? 'foo' : 'bar';

// Bad
$result = $object instanceof Model ?
    $object->name : 
   'A default value';
```

## Comments

Comments should be avoided as much as possible by writing expressive code. If you do need to use a comment format it like this:

```php
// There should be space before a single line comment.

/*
 * If you need to explain a lot you can use a comment block. Notice the
 * single * on the first line. Comment blocks don't need to be three
 * lines long or three characters shorter than the previous line.
 */
```

## Whitespace

Statements should have to breathe. In general always add blank lines between statements, unless they're a sequence of single-line equivalent operations. This isn't something enforcable, it's a matter of what looks best in it's context.

```php
// Good
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();

    if (! $page) {
        return null;
    }

    if ($page['private'] && ! Auth::check()) {
        return null;
    }

    return $page;
}

// Bad: Everything's cramped together.
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();
    if (! $page) {
        return null;
    }
    if ($page['private'] && ! Auth::check()) {
        return null;
    }
    return $page;
}
```

```php
// Good: A sequence of single-line equivalent operations.
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

Don't add any extra empty lines between `{}` brackets.

```php
// Good
if ($foo) {
    $this->foo = $foo;
}

// Bad
if ($foo) {

    $this->foo = $foo;

}
```