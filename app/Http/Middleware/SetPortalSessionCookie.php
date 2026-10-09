<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPortalSessionCookie
{
    /**
     * Give the customer portal its own session cookie so logging in/out
     * there never invalidates the admin panel's session in the same browser.
     *
     * Livewire's AJAX endpoints (e.g. /livewire/update) are shared by every
     * page, so a plain path check misses them — we fall back to the Referer
     * header to tell whether the request originated from a portal page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('portal*') || str_contains((string) $request->headers->get('referer'), '/portal')) {
            config(['session.cookie' => 'pak-tolong-portal-session']);
        }

        return $next($request);
    }
}
