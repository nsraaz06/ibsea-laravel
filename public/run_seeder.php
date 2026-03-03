<?php

/**
 * IBSEA Inquiry Form Seeder Script
 * This script creates the 'payment-inquiry' form in the database.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Form;

try {
    echo "<h1>IBSEA Inquiry Form Setup</h1>";
    
    $form = Form::updateOrCreate(
        ['slug' => 'payment-inquiry'],
        [
            'title' => 'Payment & Access Inquiry',
            'description' => 'Used when no active payment gateway is connected. Collected inquiries appear in the Intelligence Log.',
            'fields' => [
                [
                    'name' => 'full_name',
                    'label' => 'Full Name',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Enter your full name'
                ],
                [
                    'name' => 'email_address',
                    'label' => 'Institutional Email',
                    'type' => 'email',
                    'required' => true,
                    'placeholder' => 'Enter your email'
                ],
                [
                    'name' => 'whatsapp_number',
                    'label' => 'WhatsApp / Mobile Number',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Enter your contact number'
                ],
                [
                    'name' => 'purposed_item',
                    'label' => 'Interest / Item Name',
                    'type' => 'text',
                    'required' => true,
                    'readonly' => true
                ],
                [
                    'name' => 'additional_message',
                    'label' => 'Additional Intelligence / Requirements',
                    'type' => 'textarea',
                    'required' => false,
                    'placeholder' => 'Tell us more about your inquiry...'
                ]
            ],
            'settings' => [
                'success_message' => 'Your inquiry has been logged. Our institutional team will connect with you soon.',
                'submit_button_text' => 'Submit Inquiry Request'
            ],
            'is_active' => true
        ]
    );
    
    echo "<h3 style='color: green;'>Success! The 'Payment Inquiry' form has been created/updated in your database.</h3>";
    echo "<p>You can now submit inquiries without the maintenance error.</p>";
    echo "<p style='color: red;'><strong>SECURITY ACTION: Please DELETE this file (run_seeder.php) from your public folder right now!</strong></p>";

} catch (\Exception $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
}
