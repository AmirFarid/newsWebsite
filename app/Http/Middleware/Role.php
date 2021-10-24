<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 8/13/20
 * Time: 4:52 PM
 */

namespace App\Http\Middleware;

use App\Domains\BaseDomain\Helpers\GlobalHelper;
use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  \Closure $next
     * @param  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if (auth()->guest() || !$request->user()->hasRole($roles)) {
            abort(403);
        }

        return $next($request);
    }
}
