<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the Privacy Policy page.
     */
    public function privacy()
    {
        return view('pages.privacy', [
            'title' => 'Privacy Policy | IBSEA'
        ]);
    }

    /**
     * Display the Terms and Conditions page.
     */
    public function terms()
    {
        return view('pages.terms', [
            'title' => 'Terms and Conditions | IBSEA'
        ]);
    }

    /**
     * Display the Refund Policy page.
     */
    public function refund()
    {
        return view('pages.refund', [
            'title' => 'Refund Policy | IBSEA'
        ]);
    }
}
