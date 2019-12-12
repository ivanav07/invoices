<?php

namespace App\Http\Middleware;

use App\Invoice;
use Closure;
use Illuminate\Support\Facades\Auth;

class ShowInvoice
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
        $invoiceId = $request->segment(2);
        $user = Auth::user();
        if(!$user->admin && Invoice::find($invoiceId)->user()->id !== $user->id ){
            return redirect('/');
        }
        return $next($request);
    }
}
