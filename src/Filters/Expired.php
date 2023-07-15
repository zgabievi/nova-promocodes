<?php

namespace Aberbin96\NovaPromocodes\Filters;

use Laravel\Nova\Filters\Filter;
use Illuminate\Http\Request;

class Expired extends Filter
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
        if ($value === true)
            return $query->whereNotNull('expired_at')->where('expired_at', '<=', now());
        else if ($value === false)
            return $query->whereNull('expired_at')->orWhere('expired_at', '>', now());

        return $query;
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
