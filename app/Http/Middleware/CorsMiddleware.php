<?php
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        //
        $allowedDomains = array(config('services.front_end.base_uri'), null);

        $origin = $request->server('HTTP_ORIGIN');

        if(in_array($origin, $allowedDomains)){
            //Intercepts OPTIONS requests
            if($request->isMethod('OPTIONS')) {
                $response = response('', 200);
            } else {
                // Pass the request to the next middleware
                $response = $next($request);
            }
            // Adds headers to the response
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            $response->headers->set('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        }else{
            $response = response('Cors Error', 405);
        }

        // Sends it
        return $response;
    }
}
