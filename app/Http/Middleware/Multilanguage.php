<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;
use Closure;
use Cookie;
use Session;
use Config;
use App;

class Multilanguage
{
  public function handle($request, Closure $next)
  {
      $languages = Config::get('app.locales');
      $locales = array_keys( $languages );
      $defaultLocale = Config::get('app.fallback_locale');

      $urlArray = parse_url($request->fullUrl());
      $pathArray = $request->segments();
      $query = isset($urlArray['query']) ? '?'.$urlArray['query'] : '';
      $path_array = explode('/', rtrim($request->path(), '/'));
      $path = implode('/', array_diff($path_array, $locales)) . $query;
      $localeInUrl = in_array( $request->segment(1), $locales )
        ? $request->segment(1)
        : false;

      /* добываем язык юзера */
      if( Session::has('set_locale') ):
          $locale = strtolower( Session::get('set_locale') );
          Session::forget('set_locale');
          Session::put('locale', $locale);
      elseif( $localeInUrl ):
          $locale = $localeInUrl;
      else:
          $locale = Session::has('locale')
            ? Session::get('locale')
            : $defaultLocale;
      endif;

      /* если язык дефолтный - не добавляем в url */
      $localeSlug = ( $locale != $defaultLocale ? $locale : '' );

      /* редиректим на новый url если необходимо */
      if( (!$localeInUrl && $locale != $defaultLocale) ||
           ($localeInUrl && $locale == $defaultLocale) ||
           ($localeInUrl && $locale != $localeInUrl) ) :
         $redirectTo = (!empty($localeSlug) ? '/'.$localeSlug : '').(!empty($path) ? '/'.$path : '');
         return redirect($redirectTo);
      endif;

      Session::put('locale', $locale);

      $_language = $this->cast_to_object($languages[$locale]);
      $_languages = $this->cast_to_object($languages);

      // Раскоментить если нужно удалить текущий язык из списка на странице
      // $languages = array_filter($languages, function($val) use ($locale) {
      //   return strtolower($val) != $locale;
      // }, ARRAY_FILTER_USE_KEY);

      // Делимся информацией с вьюшками
      view()->share('_language', $_language);
      view()->share('_languages', $_languages);
      return $next($request);
  }

  private function cast_to_object($array) {
    $o = new \stdClass;
    foreach($array as $k => $v):
       if(strlen($k)):
          if(is_array($v)):
             $o->{$k} = $this->cast_to_object($v);
          else:
             $o->{$k} = $v;
          endif;
       endif;
    endforeach;
    return $o;
  }

  private function cast_to_array($object) {
    $o = [];
    foreach($object as $k => $v):
       if(strlen($k)):
         $o[$k] = is_object($v) ? $this->cast_to_array($v) : $v;
       endif;
    endforeach;
    return $o;
  }

}
