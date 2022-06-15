<?php

namespace App\Http\Middleware;
use Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
     protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if(Route::is('admin_*')){
                 return route('admin_login_page');
            }
            else{
                return route('login');
            }

                
        }
    }
}
