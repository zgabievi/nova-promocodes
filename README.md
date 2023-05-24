[![#StandWithUkraine](https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1)](https://supportukrainenow.org)
[![nova-promocodes](https://banners.beyondco.de/Nova%20Promocodes.jpeg?theme=light&packageManager=composer+require&packageName=zgabievi%2Fnova-promocodes&pattern=topography&style=style_2&description=A+Laravel+Nova+tool+for+zgabievi%2Flaravel-promocodes+library&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)](https://github.com/Aberbin96/nova-promocodes-4)

# nova-promocodes

[![Packagist](https://img.shields.io/packagist/v/Aberbin96/nova-promocodes-4.svg)](https://packagist.org/packages/Aberbin96/nova-promocodes-4)
[![Packagist](https://img.shields.io/packagist/dt/Aberbin96/nova-promocodes-4.svg)](https://packagist.org/packages/Aberbin96/nova-promocodes-4)
[![license](https://img.shields.io/github/license/Aberbin96/nova-promocodes-4.svg)](https://packagist.org/packages/Aberbin96/nova-promocodes-4)

Coupons and promotional codes generator for [Laravel Nova](https://nova.laravel.com). This package is created for [zgabievi/laravel-promocodes](https://github.com/zgabievi/laravel-promocodes).

## Installation

You can install the package via composer:

```bash
composer require Aberbin96/nova-promocodes-4
```

## Configuration

```bash
php artisan vendor:publish --provider="Zorb\NovaPromocodes\ToolServiceProvider"
```

Now you can change configurations as you need:

```php
return [
    'models' => [
        'promocodes' => [
            'resource' => \Zorb\NovaPromocodes\Resources\Promocode::class,
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

## Usage

It's very easy to use. Methods are combined, so that you can configure promocodes easily.

- [Reference](#reference)
- [Include Tool](#include-tool)
- [Parent Package](#parent-package)

## Reference

| Name          | Explanation                                                                                                             |
|---------------|-------------------------------------------------------------------------------------------------------------------------|
| Mask          | Astrisks will be replaced with random symbol                                                                            |
| Characters    | Allowed symbols to use in mask replacement                                                                              |
| Multi use     | Define if single code can be used multiple times, by the same user                                                      |
| Unlimited     | Generated code will have unlimited usages                                                                               |
| Bound to user | Define if promocode can be used only one user, if user is not assigned initially, first user will be bound to promocode |
| User          | Define user who will be initially bound to promocode                                                                    |
| Count         | Amount of unique promocodes should be generated                                                                         |
| Usages        | Define how many times can promocode be used                                                                             |
| Expiration    | DateTime when promocode should be expired. Null means that promocode will never expire                                  |
| Details       | Array of details which will be retrieved upon apply                                                                     |

## Include Tool

Include promocodes tool inside nova service provider.

```php
use Zorb\NovaPromocodes\PromocodesTool;

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
```

## Parent Package

For more information about parent package, visit [zgabievi/laravel-promocodes](https://github.com/zgabievi/laravel-promocodes).

## Contributing

Please see [CONTRIBUTING](https://github.com/Aberbin96/nova-promocodes-4/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Zura Gabievi](https://github.com/zgabievi)
- [All Contributors](https://github.com/Aberbin96/nova-promocodes-4/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/Aberbin96/nova-promocodes-4/blob/master/LICENSE.md)
for more information.
