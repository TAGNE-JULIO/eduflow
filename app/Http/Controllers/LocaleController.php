<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch application locale.
     */
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['fr', 'en', 'es'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
