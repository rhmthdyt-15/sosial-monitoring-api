<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequestResponse
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        // Lanjutkan request
        $response = $next($request);

        // Hitung waktu eksekusi
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        // Buat log dalam format yang sesuai
        $log = sprintf(
            "%s %s %s %.2f ms %.2f KB",
            $request->method(),
            $request->path(),
            $response->status(),
            $duration,
            $this->getResponseSize($response)
        );

        // Tampilkan log di konsol
        $this->logToConsole($log);

        return $response;
    }

    private function getResponseSize(Response $response): float
    {
        $content = $response->getContent();
        return $content ? strlen($content) / 1024 : 0; // Size in KB
    }

    private function logToConsole(string $log): void
    {
        if (app()->runningInConsole()) {
            echo $log . PHP_EOL;
        }
    }
}