<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OnlyCurrentEmployee
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
        $wonde = app(\Wonde\Client::class);
        $school = $wonde->school(config('app.wonde.school_id'));

        try {
            $employee = $school->employees->get($request->user()->uid, ['employment_details']);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error($e->getMessage());
            abort(403);
        }

        // Handle not currently employed
        if (!$employee->employment_details->data->current) {
            abort(403);
        }

        $request->employee = $employee;
        return $next($request);
    }
}
