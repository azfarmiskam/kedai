<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: URL parameter > User preference > Session > Default
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
            
            // Save to user if authenticated
            if (auth()->check()) {
                auth()->user()->update(['preferred_language' => $locale]);
            }
        } elseif (auth()->check() && auth()->user()->preferred_language) {
            $locale = auth()->user()->preferred_language;
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
