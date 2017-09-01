<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Bid;

class StageReidrect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $obid=Bid::find($request->id);
        switch ($obid->stage) {
            case '5':
                return redirect()->action(
                    'BidsController@bid_over', ['id' => $obid->id]
                );
                break;

        }
        return $next($request);
    }
}
