<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Candidate;
use App\Supervisor;

class ApiAuthenticate {
  const API_KEY_HEADER = 'x-api-key';

  public function handle(Request $request, Closure $next) {
    $token = $request->header(self::API_KEY_HEADER);

    if ($token == null || (Candidate::where('api_token', $token) == null) && Supervisor::where('api_token', $token)) {
      abort(403, 'Access denied');
    }

    $request->attributes->add(['api_token' => $token]);

    return $next($request);
  }
}