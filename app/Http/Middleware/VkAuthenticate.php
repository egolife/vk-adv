<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VkAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Проверка временная - нужно запрашивать наличие токена у ВК, а не в сессии
        //поскольку возможна ситуация, когда в сессии токен есть, а для ВК он устарел
        if (!Session::has('vk_token'))
            return redirect()->route('authorize');

        return $next($request);
    }
}
