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
        // Hanya enforce untuk request yang seharusnya dari browser (tanpa Bearer)
        if (Str::startsWith($request->header('Authorization',''), 'Bearer ')) {
            return $next($request);
        }

        $allowed = array_map('trim', explode(',', env('ALLOWED_ORIGINS', 'https://digital.mitratel.co.id')));
        $origin  = $request->headers->get('origin') ?: $request->headers->get('referer');

        if (!$origin) {
            return response()->json(['message' => 'Origin missing'], 403);
        }

        $o = $this->originOnly($origin);
        $ok = collect($allowed)->contains(fn($a) => Str::startsWith($o, rtrim($a,'/')));
        if (!$ok) return response()->json(['message' => 'Origin not allowed'], 403);

        return $next($request);
    }

    private function originOnly(string $url): string {
        $p = parse_url($url);
        if (!$p || empty($p['scheme']) || empty($p['host'])) return $url;
        return $p['scheme'].'://'.$p['host'].(!empty($p['port'])?':'.$p['port']:'');
    }
}
