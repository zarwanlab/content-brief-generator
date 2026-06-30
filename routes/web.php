<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BriefController;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    if ($request->has('lang')) {
        $locale = $request->get('lang');
        if (in_array($locale, ['en', 'fa', 'ar'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
    }
    return view('welcome');
});

Route::post('/generate-brief', [BriefController::class, 'generate'])->name('brief.generate');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fa', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');
