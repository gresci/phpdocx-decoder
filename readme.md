###PhpDocx 4.6 classes decoder

[http://www.phpdocx.com/](http://www.phpdocx.com/)

Don't forget to change classes loading function in AutoLoader.inc at line 48
to something like this:

```php
public static function autoloadGenericClasses($className)
{
    $pathToClass = dirname(__FILE__) . '/' . $className . '.inc';
    if (file_exists($pathToClass)) {
        require_once $pathToClass;
    }
}
```

Trial message located in CreateDocx.inc from line 3223 to 3277
