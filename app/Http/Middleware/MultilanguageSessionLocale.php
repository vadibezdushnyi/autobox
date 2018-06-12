<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;
use Closure;
use Cookie;
use Session;
use Config;
use App;

class MultilanguageSessionLocale
{
  public function handle($request, Closure $next)
  {
      App::setLocale(Session::get('locale'));
      return $next($request);
  }
}
