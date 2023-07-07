<?php

namespace Aberbin\NovaPromocodes\Actions;

use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Illuminate\Bus\Queueable;

class ExpirePromocode extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Expire');
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $promocode = $models->first();

        if ($promocode->code && expirePromocode($promocode->code)) {
            return Action::message(__('Promocode `:code` has been marked as expired!', ['code' => $promocode->code]));
        }

        return Action::danger(__("Promocode coudn't be marked as expired!"));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [];
    }
}
