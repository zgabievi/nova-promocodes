<?php

namespace Aberbin96\NovaPromocodes\Filters;

use Laravel\Nova\Filters\Filter;
use Illuminate\Http\Request;

class NoUsagesLeft extends Filter
{
    public function name()
    {
        return __('No Usages Left');
    }

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
            return $query->where('usages_left', 0);
        else if ($value === false)
            return $query->whereNot('usages_left', 0);

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
