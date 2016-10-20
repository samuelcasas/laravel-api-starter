```
artisan migrate
artisan passport:install
```

Until fix from laravel-generators' a fix to add the trait should be added to any model like:

```
class User extends Model {
    use HelperTrait;
    ...
}
```