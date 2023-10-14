<?php

namespace Aberbin96\NovaPromocodes\Resources;

use Laravel\Nova\Fields\{BelongsTo, DateTime, KeyValue, Boolean, Number, Text, ID};
use Zorb\Promocodes\Contracts\PromocodeContract;
use Illuminate\Http\Request;

class PromocodeBatch extends Resource
{
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PromocodeContract::class;

    /**
     * Hide resource from Nova's standard menu.
     *
     * @var bool
     */
    public static $displayInNavigation = false;
    
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'code',
    ];

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function newModel(): mixed
    {
        $model = app(PromocodeContract::class);

        return new $model;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        $userResource = explode('\\', config('promocodes.models.users.resource'));
        $userResource = last($userResource);

        return [
            Number::make(__('Amount'), 'amount')
                ->default(1)
                ->help(__('How many promocodes should be created?'))
                ->required()
                ->onlyOnForms(),

            BelongsTo::make($userResource)
                ->nullable(),

            Text::make(__('Code'), 'code')
                ->exceptOnForms(),

            Text::make(__('Mask'), 'mask')
                ->default(config('promocodes.code_mask'))
                ->required()
                ->onlyOnForms(),

            Text::make(__('Characters'), 'characters')
                ->default(config('promocodes.allowed_symbols'))
                ->required()
                ->onlyOnForms(),

            Boolean::make(__('Unlimited'), 'unlimited')
                ->default(false)
                ->onlyOnForms(),

            Number::make(__('Usages Left'), 'usages_left')
                ->default(1)
                ->onlyOnForms(),

            Boolean::make(__('Bound to User'), 'bound_to_user')
                ->default(false)
                ->onlyOnForms(),

            Boolean::make(__('Multi Use'), 'multi_use')
                ->default(false)
                ->onlyOnForms(),

            DateTime::make(__('Expired at'), 'expired_at')
                ->nullable()
                ->onlyOnForms(),

            KeyValue::make(__('Details'), 'details'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
