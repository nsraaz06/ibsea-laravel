<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipPlan;

class MembershipPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id' => 'booster',
                'title' => 'Booster',
                'tagline' => 'Start Growing Your Business with IBSEA',
                'fee' => 1999,
                'days' => 365,
                'theme' => 'Slate',
                'benefits' => ['Networking', 'ID Card', '50hr Training'],
                'highlights' => ['Exclusive WhatsApp Access', '50 Hours Business Training', 'Membership E-Certificate'],
                'detailed_benefits' => [
                    ['icon' => 'public', 'title' => 'Networking', 'text' => 'Access to IBSEA conferences and selected networking meetups.'],
                    ['icon' => 'psychology', 'title' => 'Training', 'text' => '50 hours of business growth training annually.'],
                    ['icon' => 'discount', 'title' => 'Discounts', 'text' => '10% discount on Vyapar Badhao services and conclaves.'],
                    ['icon' => 'badge', 'title' => 'Credentials', 'text' => 'Get a verified Membership E-Certificate & ID Card.']
                ],
                'premium_features' => [
                    ['title' => 'Community Access', 'text' => 'Exclusive entry to our active WhatsApp business network.'],
                    ['title' => 'Partner Discounts', 'text' => 'Exclusive pricing for all IBSEA flagship events.']
                ],
                'stats' => [
                    ['title' => 'Skill Boost', 'text' => 'Members reported 30% faster skill acquisition in first 6 months.'],
                    ['title' => 'Reach', 'text' => 'Connect with 1000+ local entrepreneurs in your first year.']
                ]
            ],
            [
                'id' => 'corporate-booster',
                'title' => 'Corporate Booster',
                'tagline' => 'Strengthen Your Brand. Expand Your Reach.',
                'fee' => 4999,
                'days' => 365,
                'theme' => 'Primary',
                'benefits' => ['MSME Strategy', 'Logo Display'],
                'highlights' => ['Priority Certification Processing', 'Annual Strategy Workshop', 'Logo Display on Site'],
                'detailed_benefits' => [
                    ['icon' => 'visibility', 'title' => 'Brand Visibility', 'text' => 'Company logo display on IBSEA website and marketing materials.'],
                    ['icon' => 'videocam', 'title' => 'Video Promo', 'text' => 'Get a personalized promotional video for your brand.'],
                    ['icon' => 'stars', 'title' => 'Awards', 'text' => 'Nomination priority for Bharat Ke Maharathi Awards.'],
                    ['icon' => 'corporate_fare', 'title' => 'Corporate ID', 'text' => 'Verified Accreditation Certificate & Company ID Card.']
                ],
                'premium_features' => [
                    ['title' => 'Brand Strategy', 'text' => '1 Brand Strategy Meeting with IBSEA Core Team.'],
                    ['title' => 'Mentorship', 'text' => '50 Hours Virtual Strategic Mentorship access.'],
                    ['title' => 'Speaking Ops', 'text' => 'Round table speaking opportunities in selected programs.']
                ],
                'stats' => [
                    ['title' => 'Growth', 'text' => 'MSMEs see 40% increased visibility in the first year.'],
                    ['title' => 'Network', 'text' => 'Direct access to Director & Mentors Conclave.']
                ]
            ],
            [
                'id' => 'corporate-prime',
                'title' => 'Corporate Prime',
                'tagline' => 'Premium Visibility. Strategic Connections.',
                'fee' => 100000,
                'days' => 365,
                'theme' => 'Navy',
                'benefits' => ['Diplomatic Access', '4 Leads/Mo'],
                'highlights' => ['Diplomatic Access', '4 Business Leads/Mo', 'Magazine Feature'],
                'detailed_benefits' => [
                    ['icon' => 'handshake', 'title' => 'B2G Access', 'text' => 'Access to diplomatic engagements and government executive meetings.'],
                    ['icon' => 'leaderboard', 'title' => 'Lead Gen', 'text' => 'Receive 4 high-quality business leads every month.'],
                    ['icon' => 'podcasts', 'title' => 'Podcasts', 'text' => '3 professional podcasts with promotional reach.'],
                    ['icon' => 'map', 'title' => 'Pan-India Network', 'text' => 'Direct access to State Presidents and Vice Presidents.']
                ],
                'premium_features' => [
                    ['title' => 'Global Leads', 'text' => 'National and Global business leads delivered quarterly.'],
                    ['title' => 'Stage Sharing', 'text' => 'Share the stage in up to 5 major IBSEA conferences.'],
                    ['title' => 'Marketing Toolkit', 'text' => 'Logo promotion across all IBSEA digital and physical platforms.']
                ],
                'stats' => [
                    ['title' => 'Leads', 'text' => 'Prime members generate averaging 50+ B2B connections annually.'],
                    ['title' => 'Influence', 'text' => 'Participate in high-stakes policy advocacy sessions.']
                ]
            ],
            [
                'id' => 'lifetime',
                'title' => 'Lifetime',
                'tagline' => 'Secure Long-Term Growth until 2047',
                'fee' => 25000,
                'days' => 7670,
                'theme' => 'Gold',
                'benefits' => ['Valid until 2047', 'Magazine Feature'],
                'highlights' => ['Valid until Dec 2047', '10 Yearly Event Passes', 'Strategic Consultations'],
                'detailed_benefits' => [
                    ['icon' => 'history_edu', 'title' => 'Legacy Access', 'text' => 'Full access to all IBSEA programs and trainings until 2047.'],
                    ['icon' => 'article', 'title' => 'Editorial', 'text' => 'Featured story in our official magazine annually.'],
                    ['icon' => 'psychology', 'title' => 'Consultations', 'text' => '5 strategic one-on-one consultations every year.'],
                    ['icon' => 'nature_people', 'title' => 'Impact', 'text' => 'Participate in exclusive sustainability and tree plantation initiatives.']
                ],
                'premium_features' => [
                    ['title' => 'Speaking Rights', 'text' => 'Speaking opportunity at events (up to 2 per year).'],
                    ['title' => 'Business Kit', 'text' => 'Receive the premium physical IBSEA Business Kit.'],
                    ['title' => 'Priority', 'text' => 'Priority invitations to all closed-door official meetups.']
                ],
                'stats' => [
                    ['title' => 'Endurance', 'text' => 'Locked in benefits for 20+ years regardless of future fee hikes.'],
                    ['title' => 'Network', 'text' => 'Lifetime access to the elite mentor network.']
                ]
            ]
        ];

        foreach ($plans as $p) {
            MembershipPlan::updateOrCreate(['id' => $p['id']], [
                'title' => $p['title'],
                'tagline' => $p['tagline'],
                'fee_numeric' => $p['fee'],
                'validity_days' => $p['days'],
                'benefits_json' => $p['benefits'],
                'highlights_json' => $p['highlights'],
                'detailed_benefits_json' => $p['detailed_benefits'],
                'premium_features_json' => $p['premium_features'],
                'stats_json' => $p['stats'],
                'theme' => $p['theme']
            ]);
        }
    }
}
