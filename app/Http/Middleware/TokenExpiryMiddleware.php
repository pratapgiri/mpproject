<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Middleware\GetUserFromToken;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenExpiryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $response['status'] = false;
        $response['data'] = (object)[];
        if (!$token = JWTAuth::getToken()) {
            $response['message'] = Config::get('message-constants.Token_required');

            return response()->json($response, 401);
        }

        try {
            $user = JWTAuth::authenticate($token);
        } catch (TokenExpiredException $e) {
            $response['message'] =  Config::get('message-constants.Token_Expired');
            return response()->json($response, 401);
        } catch (JWTException $e) {
            $response['message'] =  Config::get('message-constants.Token_Token');
            return response()->json($response, 401);
        }
        if (!$user) {
            $response['message'] =  Config::get('message-constants.User_not_exist');
            return response()->json($response, 201);
        }

        return $next($request);
    }
}
