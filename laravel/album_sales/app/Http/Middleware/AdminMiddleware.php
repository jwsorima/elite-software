<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware {
  public function handle(Request $request, Closure $next): Response {
    $allowedPublicRoutes = [
      'api/login',
      'api/logout',
      'api/dashboard/search-albums',
      'api/artists',
      'api/albums'
    ];

    if (in_array($request->path(), $allowedPublicRoutes) || 
      str_starts_with($request->path(), 'api/albums/')) {
      return $next($request);
    }

    if (!$request->user()) {
      return response()->json(['message' => 'Unauthenticated'], 401);
    }  

    return $next($request);
  }
}
