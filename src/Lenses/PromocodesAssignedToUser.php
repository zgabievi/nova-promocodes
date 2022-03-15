<?php

namespace Zorb\NovaPromocodes\Lenses;

use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Fields\{
    BelongsTo,
    DateTime,
    Boolean,
    Number,
    Text,
    ID
};
use Laravel\Nova\Lenses\Lens;
use Illuminate\Http\Request;

class PromocodesAssignedToUser extends Lens
{
    /**
     * Get the displayable name of the lens.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Assigned to User');
    }

    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->whereNotNull('user_id')
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $userResource = explode('\\', config('nova-promocodes.models.users.resource'));
        $userResource = last($userResource);

        return [
            ID::make()->sortable(),

            BelongsTo::make($userResource),

            Text::make(__('Code'), 'code'),

            Number::make(__('Usages Left'), 'usages_left'),

            Boolean::make(__('Bound to User'), 'bound_to_user'),

            Boolean::make(__('Multi Use'), 'multi_use'),

            DateTime::make(__('Expired at'), 'expired_at'),
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'promocodes-assigned-to-user';
    }
}
