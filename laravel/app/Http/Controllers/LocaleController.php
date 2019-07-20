<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Изменение локализации
     *
     * @param string $locale
     * @return \Illuminate\Http\Response
     */
    public function change($locale)
    {
        Session::put('locale', $locale);
        return redirect()
            ->back();
    }
}
