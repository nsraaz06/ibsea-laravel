<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\SiteSetting;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page.
     */
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key');
        
        // We can link a dynamic form if exists, or just use a static one in the view
        $contactForm = Form::where('slug', 'contact-us')->first();

        return view('pages.contact', [
            'title' => 'Contact Us | IBSEA',
            'settings' => $settings,
            'contactForm' => $contactForm
        ]);
    }
}
