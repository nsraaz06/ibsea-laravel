<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Initiative;
use Illuminate\Support\Str;

class InitiativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initiatives = [
            [
                'title' => 'India @2047 Conference & Bharat Ke Maharathi',
                'summary' => 'A flagship national platform bringing together policymakers, industry leaders, and entrepreneurs to drive nation-building, recognize excellence, and shape India’s growth journey toward 2047.',
                'content' => '<h2>Vision 2047</h2><p>The India @2047 Conference is a premier event dedicated to visualizing and strategizing India\'s path to becoming a developed nation by the centenary of its independence.</p><ul><li>Strategic Leadership</li><li>Nation Building</li><li>Entrepreneurial Excellence</li></ul>',
                'icon' => 'flag',
                'organizer_name' => 'Anshumaan Singh',
                'organizer_role' => 'Organiser',
                'organizer_image_path' => 'uploads/members/698f90b40b785.jpg',
                'organizer_email' => 'contact@bharatkemahathi.com',
                'sort_order' => 1,
            ],
            [
                'title' => 'Vyapar Badhao',
                'summary' => 'A focused business growth initiative designed to help MSMEs and entrepreneurs increase visibility, revenue, and market reach through structured support and ecosystem connections.',
                'content' => '<h2>Empowering MSMEs</h2><p>Vyapar Badhao is more than an initiative; it\'s a movement to scale micro, small, and medium enterprises through market access and technological integration.</p>',
                'icon' => 'trending_up',
                'organizer_name' => 'Md Shahzad',
                'organizer_role' => 'Head - Vyapar Badhao',
                'organizer_image_path' => 'uploads/members/698f8a6355093.jpg',
                'organizer_email' => 'vyaparbadhao@ibsea.in',
                'sort_order' => 2,
            ],
            [
                'title' => 'Center of Excellence (CoE)',
                'summary' => 'Industry-aligned centers dedicated to skill development, innovation, and practical learning—bridging the gap between education, industry, and entrepreneurship.',
                'content' => '<h2>Bridging the Gap</h2><p>Our Centers of Excellence provide a hands-on environment for developing industry-ready skills and fostering innovative solutions for modern business challenges.</p>',
                'icon' => 'school',
                'organizer_name' => 'Brig. Arun Gupta',
                'organizer_role' => 'Head-Mentors/Trainers Alliances',
                'organizer_image_path' => 'uploads/members/698f89e4b5741.jpg',
                'sort_order' => 3,
            ],
            [
                'title' => 'Corporate Training Program',
                'summary' => 'Customized training solutions for organizations to upskill teams, build leadership capability, and enhance productivity through industry-relevant learning modules.',
                'content' => '<h2>Transformational Learning</h2><p>We offer specialized training programs designed to align with corporate objectives and drive individual and organizational performance.</p>',
                'icon' => 'groups',
                'organizer_name' => 'Prabhat Sinha',
                'organizer_role' => 'Head-Corporate Training Alliances',
                'organizer_image_path' => 'uploads/members/698f8a230d5b1.jpg',
                'sort_order' => 4,
            ],
            [
                'title' => 'Director Mentor Conclave',
                'summary' => 'An exclusive forum connecting founders with experienced directors, mentors, and advisors to gain strategic guidance, governance insights, and leadership direction.',
                'content' => '<h2>Strategic Guidance</h2><p>The Director Mentor Conclave is a elite sanctuary for founders to receive unvarnished advice from veteran corporate leaders.</p>',
                'icon' => 'psychology',
                'organizer_name' => 'IBSEA Mentors',
                'organizer_role' => 'Strategic Advisory',
                'organizer_image_path' => 'uploads/members/698f90b40b785.jpg',
                'sort_order' => 5,
            ],
            [
                'title' => 'Growth Exchange Program',
                'summary' => 'A collaborative networking platform enabling entrepreneurs to exchange ideas, partnerships, and growth opportunities through curated physical and virtual meetups.',
                'content' => '<h2>Collaborative Ecosystem</h2><p>Growth Exchange fosters a peer-to-peer network where business owners can find synergies and collaborate on expansive opportunities.</p>',
                'icon' => 'handshake',
                'organizer_name' => 'Anshumaan Singh',
                'organizer_role' => 'Organiser',
                'organizer_image_path' => 'uploads/members/698f90b40b785.jpg',
                'organizer_email' => 'contact@bharatkemahathi.com',
                'sort_order' => 6,
            ],
        ];

        foreach ($initiatives as $init) {
            $init['slug'] = Str::slug($init['title']);
            $init['is_active'] = true;
            Initiative::updateOrCreate(['slug' => $init['slug']], $init);
        }
    }
}
