<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Exceptions\AuthenticateException;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $roleUserName = optional($user)->getRelationValue('role')->name;
            if ($roleUserName == Role::ROLE_USER) {
                return $next($request);
            } else {
                throw AuthenticateException::code(Lang::get('errors.cant_access_this_page'))->setMessageCode('400');
            }
        } else {
            throw AuthenticateException::code(Lang::get('errors.cant_access_this_page'))->setMessageCode('400');
        }
    }
}
