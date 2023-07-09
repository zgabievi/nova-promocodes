
# Nova 4 promocodes
Adaptation of the promocodes library for laravel nova 4.

Old version: https://github.com/zgabievi/nova-promocodes
## Configuration

```bash
    php artisan vendor:publish --provider="Aberbin96\NovaPromocodes\ToolServiceProvider"
```

Now you can change configurations as you need:

```bash
    return [
        'models' => [
            'promocodes' => [
                'resource' => \Aberbin96\NovaPromocodes\Resources\Promocode::class,
            ],

            'users' => [
                'resource' => \App\Nova\User::class,
            ],
        ],
    ];
```

After you configure this file, run migrations:

```bash
    php artisan migrate
```

## Include Tool

Include promocodes tool inside nova service provider.

```php
use Aberbin96\NovaPromocodes\PromocodesTool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    // ...

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            PromocodesTool::make(),
        ];
    }
}
```## Parent Package

For more information about parent package, visit [zgabievi/laravel-promocodes](https://github.com/zgabievi/laravel-promocodes).

## Credits

- [Zura Gabievi](https://github.com/zgabievi)
- [@Aberbin96](https://github.com/Aberbin96)
- [All Contributors](https://github.com/zgabievi/nova-promocodes/graphs/contributors)