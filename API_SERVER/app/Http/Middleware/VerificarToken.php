<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerificarToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $suap_token = $request->bearerToken();
        if (empty($suap_token)) {
            return response()->json(['message' => 'O token não pode estar vazio', 'status' => 401], 401);
        }

        $resp = Http::post('https://suap.ifrn.edu.br/api/v2/autenticacao/token/verify/', [
            'token' => $suap_token,
        ]);
        if ($resp->status() !== 200) {
            return response()->json(['message' => 'Token expirou ou é inválido', 'status' => $resp->status()], $resp->status());
        }

        return $next($request);
    }
}
