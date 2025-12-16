<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        // Validate locale
        if (!in_array($locale, Language::values())) {
            return back();
        }

        session(['locale' => $locale]);

        return back();
    }
}


