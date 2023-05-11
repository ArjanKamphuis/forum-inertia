<?php

namespace App\Http\Middleware;

use App\Http\Resources\ChannelsResource;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $channels = Cache::rememberForever('channels', fn() => Channel::all());
        
        $flash = ['message' => $request->session()->get('flash')];
        if ($request->session()->has('newReply')) {
            $flash['newReply'] = $request->session()->get('newReply');
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'channels' => ChannelsResource::collection($channels),
            'flash' => $flash,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
