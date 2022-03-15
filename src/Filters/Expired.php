<?php

namespace Zorb\NovaPromocodes\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Illuminate\Http\Request;

class Expired extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value) {
            return $query->whereNotNull('expired_at')->where('expired_at', '<=', now());
        }

        return $query->whereNull('expired_at')->orWhere('expired_at', '>', now());
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Yes' => true,
            'No' => false,
        ];
    }
}
