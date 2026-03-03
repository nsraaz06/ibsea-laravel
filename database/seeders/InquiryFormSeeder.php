<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;

class InquiryFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Form::updateOrCreate(
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
    }
}
