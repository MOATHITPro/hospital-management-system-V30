<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the locale from session or default to app locale
        $locale = Session::get('locale', config('app.locale'));

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
