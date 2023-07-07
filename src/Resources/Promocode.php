<?php

namespace Aberbin\NovaPromocodes\Resources;

use Aberbin\NovaPromocodes\Lenses\{
    PromocodesWithNoUsagesLeft,
    PromocodesAssignedToUser,
    PromocodesWithMultiUse,
    PromocodesBoundToUser,
    UnlimitedPromocodes,
    ExpiredPromocodes
};
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Aberbin\NovaPromocodes\Filters\BoundToUser;
use Aberbin\NovaPromocodes\Filters\Expired;
use Aberbin\NovaPromocodes\Filters\MultiUse;
use Aberbin\NovaPromocodes\Filters\NoUsagesLeft;
use Aberbin\NovaPromocodes\Filters\Unlimited;
use Aberbin\NovaPromocodes\Actions\ExpirePromocode;
use Aberbin\Promocodes\Contracts\PromocodeContract;
use Illuminate\Http\Request;

class Promocode extends Resource
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
        $userResource = explode('\\', config('nova-promocodes.models.users.resource'));
        $userResource = last($userResource);

        return [
            ID::make()->sortable(),

            Number::make(__('Amount'), 'amount')
                ->default(1)
                ->help('How many promocodes should be created?')
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
                ->default(1),

            Boolean::make(__('Bound to User'), 'bound_to_user')
                ->default(false),

            Boolean::make(__('Multi Use'), 'multi_use')
                ->default(false),

            DateTime::make(__('Expired at'), 'expired_at')
                ->nullable(),

            KeyValue::make(__('Details'), 'details'),

            BelongsToMany::make($userResource),
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
        return [
            Expired::make(),
            MultiUse::make(),
            Unlimited::make(),
            NoUsagesLeft::make(),
            BoundToUser::make(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [
            ExpiredPromocodes::make(),
            UnlimitedPromocodes::make(),
            PromocodesWithMultiUse::make(),
            PromocodesWithNoUsagesLeft::make(),
            PromocodesBoundToUser::make(),
            PromocodesAssignedToUser::make(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            ExpirePromocode::make()
                ->showOnTableRow()
                ->canSee(fn() => !$this->resource->isExpired()),
        ];
    }
}
