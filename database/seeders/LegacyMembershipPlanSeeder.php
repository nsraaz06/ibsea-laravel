<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LegacyMembershipPlanSeeder extends Seeder
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
                'fee_numeric' => 1999.00,
                'validity_days' => 365,
                'highlights_json' => ["Exclusive WhatsApp Access","50 Hours Business Training","Membership E-Certificate"],
                'benefits_json' => ["Networking","ID Card","50hr Training"],
                'detailed_benefits_json' => [
                    ["icon" => "public", "title" => "Networking", "text" => "Access to IBSEA conferences and selected networking meetups."],
                    ["icon" => "psychology", "title" => "Training", "text" => "50 hours of business growth training annually."],
                    ["icon" => "discount", "title" => "Discounts", "text" => "10% discount on Vyapar Badhao services and conclaves."],
                    ["icon" => "badge", "title" => "Credentials", "text" => "Get a verified Membership E-Certificate & ID Card."]
                ],
                'premium_features_json' => [
                    ["title" => "Community Access", "text" => "Exclusive entry to our active WhatsApp business network."],
                    ["title" => "Partner Discounts", "text" => "Exclusive pricing for all IBSEA flagship events."]
                ],
                'stats_json' => [
                    ["title" => "Skill Boost", "text" => "Members reported 30% faster skill acquisition in first 6 months."],
                    ["title" => "Reach", "text" => "Connect with 1000+ local entrepreneurs in your first year."]
                ],
                'theme' => 'Slate'
            ],
            [
                'id' => 'corporate-booster',
                'title' => 'Corporate Booster',
                'tagline' => 'Strengthen Your Brand. Expand Your Reach.',
                'fee_numeric' => 4999.00,
                'validity_days' => 365,
                'highlights_json' => ["Priority Certification Processing","Annual Strategy Workshop","Logo Display on Site"],
                'benefits_json' => ["MSME Strategy","Logo Display"],
                'detailed_benefits_json' => [
                    ["icon" => "visibility", "title" => "Brand Visibility", "text" => "Company logo display on IBSEA website and marketing materials."],
                    ["icon" => "videocam", "title" => "Video Promo", "text" => "Get a personalized promotional video for your brand."],
                    ["icon" => "stars", "title" => "Awards", "text" => "Nomination priority for Bharat Ke Maharathi Awards."],
                    ["icon" => "corporate_fare", "title" => "Corporate ID", "text" => "Verified Accreditation Certificate & Company ID Card."]
                ],
                'premium_features_json' => [
                    ["title" => "Brand Strategy", "text" => "1 Brand Strategy Meeting with IBSEA Core Team."],
                    ["title" => "Mentorship", "text" => "50 Hours Virtual Strategic Mentorship access."],
                    ["title" => "Speaking Ops", "text" => "Round table speaking opportunities in selected programs."]
                ],
                'stats_json' => [
                    ["title" => "Growth", "text" => "MSMEs see 40% increased visibility in the first year."],
                    ["title" => "Network", "text" => "Direct access to Director & Mentors Conclave."]
                ],
                'theme' => 'Primary'
            ],
            [
                'id' => 'corporate-prime',
                'title' => 'Corporate Prime',
                'tagline' => 'Premium Visibility. Strategic Connections.',
                'fee_numeric' => 100000.00,
                'validity_days' => 365,
                'highlights_json' => ["Diplomatic Access","4 Business Leads/Mo","Magazine Feature"],
                'benefits_json' => ["Diplomatic Access","4 Leads/Mo"],
                'detailed_benefits_json' => [
                    ["icon" => "handshake", "title" => "B2G Access", "text" => "Access to diplomatic engagements and government executive meetings."],
                    ["icon" => "leaderboard", "title" => "Lead Gen", "text" => "Receive 4 high-quality business leads every month."],
                    ["icon" => "podcasts", "title" => "Podcasts", "text" => "3 professional podcasts with promotional reach."],
                    ["icon" => "map", "title" => "Pan-India Network", "text" => "Direct access to State Presidents and Vice Presidents."]
                ],
                'premium_features_json' => [
                    ["title" => "Global Leads", "text" => "National and Global business leads delivered quarterly."],
                    ["title" => "Stage Sharing", "text" => "Share the stage in up to 5 major IBSEA conferences."],
                    ["title" => "Marketing Toolkit", "text" => "Logo promotion across all IBSEA digital and physical platforms."]
                ],
                'stats_json' => [
                    ["title" => "Leads", "text" => "Prime members generate averaging 50+ B2B connections annually."],
                    ["title" => "Influence", "text" => "Participate in high-stakes policy advocacy sessions."]
                ],
                'theme' => 'Navy'
            ],
            [
                'id' => 'lifetime',
                'title' => 'Lifetime',
                'tagline' => 'Secure Long-Term Growth until 2047',
                'fee_numeric' => 25000.00,
                'validity_days' => 7670,
                'highlights_json' => ["Valid until Dec 2047","10 Yearly Event Passes","Strategic Consultations"],
                'benefits_json' => ["Valid until 2047","Magazine Feature"],
                'detailed_benefits_json' => [
                    ["icon" => "history_edu", "title" => "Legacy Access", "text" => "Full access to all IBSEA programs and trainings until 2047."],
                    ["icon" => "article", "title" => "Editorial", "text" => "Featured story in our official magazine annually."],
                    ["icon" => "psychology", "title" => "Consultations", "text" => "5 strategic one-on-one consultations every year."],
                    ["icon" => "nature_people", "title" => "Impact", "text" => "Participate in exclusive sustainability and tree plantation initiatives."]
                ],
                'premium_features_json' => [
                    ["title" => "Speaking Rights", "text" => "Speaking opportunity at events (up to 2 per year)."],
                    ["title" => "Business Kit", "text" => "Receive the premium physical IBSEA Business Kit."],
                    ["title" => "Priority", "text" => "Priority invitations to all closed-door official meetups."]
                ],
                'stats_json' => [
                    ["title" => "Endurance", "text" => "Locked in benefits for 20+ years regardless of future fee hikes."],
                    ["title" => "Network", "text" => "Lifetime access to the elite mentor network."]
                ],
                'theme' => 'Gold'
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\MembershipPlan::updateOrCreate(['id' => $plan['id']], $plan);
        }
    }
}
