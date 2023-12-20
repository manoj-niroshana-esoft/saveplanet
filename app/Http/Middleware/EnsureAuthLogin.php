<?php

namespace App\Http\Middleware;

use Closure;

class EnsureAuthLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->get('auth_user') != 1) {
            return route('login');
        } else {
            $auth_type = session()->get('auth_type');
            // dd($auth_type);
            switch ($auth_type) {
                case '1':
                    $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
                    break;
                case '2':
                    $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenuOfficer.json'));
                    break;
                case '3':
                    $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenuAdmin.json'));
                    break;
                default:
                    $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
                    break;
            }

            $verticalMenuData = json_decode($verticalMenuJson);
            $horizontalMenuJson = file_get_contents(base_path('resources/json/horizontalMenu.json'));
            $horizontalMenuData = json_decode($horizontalMenuJson);

            // Share all menuData to all the views
            \View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
        }
        return $next($request);
    }
}
