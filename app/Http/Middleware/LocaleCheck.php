<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('lang');
        $availableLangs = ['ar' => 'ar', 'en' => 'en'];

        if ($availableLangs[$lang] ?? null) {
            session()->put('lang', $lang);
        }

        app()->setLocale(session()->get('lang', 'ar'));

        return $next($request);
    }
}
