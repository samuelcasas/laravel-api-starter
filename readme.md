```
git clone --depth 1 https://github.com/samuelcasas/laravel-api-starter.git
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