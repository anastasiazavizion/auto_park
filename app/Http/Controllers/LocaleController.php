<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
class LocaleController extends Controller
{
    public function translations(): JsonResponse
    {
        $enPath = base_path('/lang/en.json');
        $enData = json_decode(file_get_contents($enPath), true);
        $uaPath = base_path('/lang/ua.json');
        $uaData = json_decode(file_get_contents($uaPath), true);
        $messages = [
            'en' => $enData,
            'ua' => $uaData,
        ];
        return response()->json($messages);
    }

    public function store(string $locale): JsonResponse
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return response()->json($locale);
    }

    public function currentLocale(): JsonResponse
    {
        $locale = session()->get('locale', app()->getLocale());
        return response()->json($locale);
    }
}
