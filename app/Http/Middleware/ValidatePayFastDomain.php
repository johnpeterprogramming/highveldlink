<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePayFastDomain
{
    /**
     * Handle an incoming request to validate PayFast webhook source.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // PayFast webhooks come from these known domains
        $allowedHosts = [
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
        ];

        // Get client IP and perform reverse DNS lookup
        $clientIp = $request->ip();
        $clientHost = gethostbyaddr($clientIp);
        
        // Validate that reverse DNS lookup succeeded (returns the IP if it fails)
        if ($clientHost === $clientIp) {
            abort(403, 'Unauthorized webhook source domain.');
        }
        
        // Validate domain by exact match only (prevents subdomain spoofing)
        if (!in_array($clientHost, $allowedHosts, true)) {
            abort(403, 'Unauthorized webhook source domain.');
        }

        return $next($request);
    }
}
