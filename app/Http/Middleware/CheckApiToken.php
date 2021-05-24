<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckApiToken
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
		// cose da fare prima di arrivare su Api\PostController@index()
		
		// prelevo token della richiesta
		$req_token = $request->header('Authorization');
		
		// verifica esistenza token nella richiesta
		if (empty($req_token)) {
			return response()->json([
				'success' => false,
				'error' => 'Missing api token'
			]);
		} 

		// se nella richiesta c'è il token, estrazione token da header
		$req_token = substr($req_token, 7); // tolgo 'Bearer ' 

		// cerco token della richiesta nella tabella users del DB
		$user = User::where('api_token',$req_token)->first();
		if(!$user) {
			return response()->json([
				'success' => false,
				'error' => 'Wrong api token'
			]);
		} 

		// proseguimento al passo successivo Api\PostController@index()
        return $next($request);
    }
}
