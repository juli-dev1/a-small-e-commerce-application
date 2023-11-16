<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CartHasProducts
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
        if (!session('cart')) {
            // return response()->json('Your have no products in cart');
            return redirect()->route('products.index');
        }
        return $next($request);
    }
}
