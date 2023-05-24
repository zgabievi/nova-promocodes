<?php

namespace Zorb\NovaPromocodes\Http\Controllers;

use Carbon\Carbon;
use Laravel\Nova\Http\Requests\CreateResourceRequest;
use Illuminate\Routing\Controller;

class ResourceStoreController extends Controller
{
    /**
     * Create a new resource.
     *
     * @param \Laravel\Nova\Http\Requests\CreateResourceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(CreateResourceRequest $request)
    {
        $userId = $request->input('user');
        $user = null;

        if ($userId) {
            $user = app(config('promocodes.models.users.model'))->findOrFail($userId);
        }

        $expiredAt = $request->input('expired_at');
        $expiration = null;

        if ($expiredAt) {
            $expiration = Carbon::parse($expiredAt);
        }

        $promocodes = createPromocodes(
            mask: $request->input('mask'),
            characters: $request->input('characters'),
            count: (int)$request->input('amount'),
            unlimited: (bool)$request->input('unlimited'),
            usages: (int)$request->input('usages_left'),
            multiUse: (bool)$request->input('multi_use'),
            user: $user,
            boundToUser: (bool)$request->input('bound_to_user'),
            expiration: $expiration,
            details: (array)json_decode($request->input('details')),
        );

        $model = $promocodes->last();

        return response()->json([
            'id' => $model->getKey(),
            'resource' => $model->attributesToArray(),
            'redirect' => '/resources/promocodes',
        ], 201);
    }
}
