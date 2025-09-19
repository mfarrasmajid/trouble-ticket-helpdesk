<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CheckOrigin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lewati untuk integrasi server-to-server (Bearer)
        if (Str::startsWith($request->header('Authorization',''), 'Bearer ')) {
            return $next($request);
        }

        // 1) Konstruksi origin "lokal" dari request (memperhatikan proxy)
        $proto = $request->header('X-Forwarded-Proto', $request->getScheme());
        $host  = $request->header('X-Forwarded-Host', $request->getHost());
        $port  = $request->getPort();
        $localOrigin = $proto.'://'.$host.(in_array($port, [80,443]) ? '' : ':'.$port);

        // 2) Ambil candidate origin dari header (jika ada)
        $origin  = $request->headers->get('origin');
        $referer = $request->headers->get('referer');
        $candidate = $origin ?: $referer;

        // 3) If header TIDAK ADA → anggap same-origin, izinkan
        if (!$candidate) {
            return $next($request);
        }

        // 4) Normalisasi candidate → scheme://host[:port]
        $cand = $this->originOnly($candidate);

        // 5) Whitelist
        $allowed = array_map('trim', explode(',', \Config::get('values.ALLOWED_ORIGINS', 'https://digital.mitratel.co.id')));
        // Selalu izinkan origin lokal (same-origin)
        $allowed[] = $localOrigin;

        $ok = collect($allowed)->contains(fn($a) => Str::startsWith($cand, rtrim($a, '/')));

        if (!$ok) {
            return response()->json(['message' => 'Origin not allowed'], 403);
        }

        return $next($request);
    }

    private function originOnly(string $url): string
    {
        $p = parse_url($url);
        if (!$p || empty($p['scheme']) || empty($p['host'])) return $url;
        return $p['scheme'].'://'.$p['host'].(!empty($p['port'])?':'.$p['port']:'');
    }
}
