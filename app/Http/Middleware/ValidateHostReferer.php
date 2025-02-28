<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateHostReferer
{
    public function handle(Request $request, Closure $next)
    {
        $allowedHost = config('app.url'); // Ambil domain dari APP_URL di .env
        $parsedUrl = parse_url($allowedHost);
        $expectedDomain = $parsedUrl['host'] ?? '';

        $requestHost = $request->getHost(); // Host dari request
        $referer = $request->headers->get('referer'); // Ambil referer

        // Jika referer ada, pastikan domainnya cocok
        if ($referer) {
            $refererHost = parse_url($referer, PHP_URL_HOST);
            if ($refererHost !== $expectedDomain) {
                return abort(403, 'Invalid Referer');
            }
        }

        // Pastikan host request juga cocok dengan domain
        if ($requestHost !== $expectedDomain) {
            return abort(403, 'Invalid Host');
        }

        return $next($request);
    }
}
