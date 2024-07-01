<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

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
        $availableLocales = [
            'en'=>asset('/images/languages/en.png'),
            'ua'=>asset('/images/languages/ua.png'),
        ];


        return [
            ...parent::share($request),
            'currentLocale'=>session()->get('locale') ?? '',
            'availableLocales'=>$availableLocales,
            'success' => $request->session()->get('success'),
            'auth' => [
                'user' => $request->user(),
                'isAdmin' => $request->user() ? $request->user()->isAdmin() : false,
            ],
        ];
    }
}
