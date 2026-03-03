/**
 * IBSEA Membership Plans Data
 * Derived from membership.md
 */

const membershipPlans = [
    {
        id: "booster",
        title: "Booster",
        fullName: "Booster Membership",
        tagline: "Start Growing Your Business with IBSEA",
        fee: "₹1,999",
        validity: "1 Year",
        overview: "Booster Membership is ideal for entrepreneurs, professionals, and early-stage businesses who want access to networking, training, and business growth opportunities.",
        highlights: [
            { icon: "groups", text: "Exclusive Networking Groups" },
            { icon: "history_edu", text: "Certification & ID Card" }
        ],
        benefits: [
            "Access to IBSEA conferences and selected networking meetups",
            "Exclusive WhatsApp community access",
            "50 hours of business growth training annually",
            "Discount coupons for conclaves and meetups",
            "Membership E-Certificate & ID Card",
            "10% discount on Vyapar Badhao services"
        ],
        detailedBenefits: [
            { icon: "public", title: "Direct Networking", text: "Connect with entrepreneurs and professionals through our verified networking meetups and WhatsApp groups." },
            { icon: "school", title: "Skill Building", text: "Get access to over 50 hours of virtual training sessions annually focused on business strategy and scale." },
            { icon: "card_membership", title: "Global Identity", text: "E-Certificate and Digital ID Card that recognizes you as a member of India's leading business ecosystem." },
            { icon: "local_offer", title: "Service Savings", text: "Get a flat 10% discount on all professional services provided by Vyapar Badhao to help your business grow." }
        ],
        premiumFeatures: [
            { title: "Strategic Resource Access", text: "Downloadable toolkits and templates for business planning and market analysis." },
            { title: "Monthly Growth Webinars", text: "Live sessions with industry experts on rotating topics relevant to early-stage growth." },
            { title: "Directory Listing", text: "Basic profile listing in the IBSEA members directory to increase your online presence." }
        ],
        stats: [
            { title: "Strong Foundation", text: "Join over 5,000+ individual members building their business future with IBSEA support." },
            { title: "Accessible Growth", text: "Designed to be the most affordable entry point for serious entrepreneurs in India." }
        ],
        eligibility: "Open for individuals, entrepreneurs, and professionals.",
        popular: false,
        theme: "slate",
        image: "https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&q=80&w=800"
    },
    {
        id: "corporate-booster",
        title: "Corporate Booster",
        fullName: "Corporate Booster Membership",
        tagline: "Strengthen Your Brand. Expand Your Reach.",
        fee: "₹4,999",
        validity: "1 Year",
        overview: "Corporate Booster Membership is designed for MSMEs, startups, NGOs, and companies looking to enhance visibility, credibility, and networking opportunities.",
        highlights: [
            { icon: "verified", text: "Priority Certification Processing" },
            { icon: "rocket_launch", text: "Annual Strategy Workshop" }
        ],
        benefits: [
            "Accreditation Certificate & Company ID Card",
            "Exclusive WhatsApp business network access",
            "Company logo display on IBSEA website",
            "Personalized promotional video",
            "Access to Director & Mentors Conclave",
            "Access to Growth Exchange Programs",
            "Access to Bharat Ke Maharathi Awards",
            "Round table speaking opportunity (selected programs)",
            "1 Brand Strategy Meeting with IBSEA Core Team",
            "50 Hours Virtual Strategic Mentorship"
        ],
        detailedBenefits: [
            { icon: "public", title: "Global Networking", text: "Connect with international partners and stakeholders through our exclusive matchmaking events and B2B forums." },
            { icon: "visibility", title: "Brand Visibility", text: "Get featured in the IBSEA Monthly Digest and premium listings on our global directory of excellence." },
            { icon: "event_available", title: "Priority Event Access", text: "Secure your spot at flagship conferences and closed-door roundtable discussions with early-bird registration." },
            { icon: "psychology", title: "Mentorship", text: "Direct access to industry veterans for guidance on regulatory compliance, scaling, and market entry strategies." }
        ],
        premiumFeatures: [
            { title: "Board-Level Consultations", text: "One-on-one quarterly sessions with IBSEA executive board members to review growth trajectories." },
            { title: "Strategic Policy Advocacy", text: "Be part of the collective voice representing corporate interests at governmental regulatory forums." },
            { title: "Bespoke Talent Acquisition", text: "Direct pipeline to certified high-performance professionals within the IBSEA network." }
        ],
        stats: [
            { title: "Accelerated Growth", text: "Companies using our Booster Tier have reported a 40% increase in cross-border partnerships within 12 months." },
            { title: "Unmatched Visibility", text: "Position your brand as a leader. Our digital footprint reaches over 50,000 industry decision-makers monthly." }
        ],
        eligibility: "Available only for registered organizations only. Individual practitioners are encouraged to apply for the Associate Tier.",
        popular: true,
        theme: "primary",
        image: "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800"
    },
    {
        id: "corporate-prime",
        title: "Corporate Prime",
        fullName: "Corporate Prime Membership",
        tagline: "Premium Visibility. Strategic Connections. High-Level Impact.",
        fee: "₹1,00,000",
        validity: "1 Year",
        overview: "Corporate Prime Membership is built for organizations seeking national visibility, business leads, and high-level networking opportunities with global impact.",
        highlights: [
            { icon: "stars", text: "Stage Sharing In 5 Conferences" },
            { icon: "hub", text: "Diplomatic & Govt Engagements" }
        ],
        benefits: [
            "5 B2B and B2G Meetups",
            "13 Program Access annually",
            "5 Meetings with IBSEA Core Team",
            "4 Business Leads (National/Global)",
            "25,000 Bulk Messages",
            "IBSEA Business Kit",
            "Stage sharing in up to 5 conferences",
            "Logo promotion across IBSEA platforms",
            "Excellence Award opportunity",
            "3 Podcasts with promotional reach",
            "Pan-India network access",
            "Access to diplomatic engagements"
        ],
        detailedBenefits: [
            { icon: "ads_click", title: "Business Leads", text: "Receive 4 high-quality national or global business leads monthly to fuel your pipeline." },
            { icon: "campaign", title: "Mass Outreach", text: "Utilize 25,000 bulk messages and podcast features to reach a massive targeted audience." },
            { icon: "podcasts", title: "Digital Authority", text: "3 dedicated podcast episodes highlighting your company's expertise and success stories." },
            { icon: "handshake", title: "VIP Engagements", text: "Direct access to diplomatic circles, government executives, and policy-making roundtables." }
        ],
        premiumFeatures: [
            { title: "National Platform Sharing", text: "Co-host or share the stage at up to 5 major IBSEA conferences across India annually." },
            { icon: "check", title: "Promotional Arsenal", text: "Comprehensive logo promotion across all physical and digital IBSEA event assets." },
            { title: "Pan-India Executive Network", text: "Direct contact line with IBSEA State Presidents and Vice Presidents for regional entry." }
        ],
        stats: [
            { title: "High Conversions", text: "Prime members see a 3x higher success rate in government tender acquisitions through our guidance." },
            { title: "National Footprint", text: "Expand your reach from regional to national with our extensive chamber of commerce network." }
        ],
        eligibility: "Registered organizations and corporates only. Requires vetting from the IBSEA core selection committee.",
        popular: false,
        theme: "navy",
        image: "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=800"
    },
    {
        id: "lifetime",
        title: "Lifetime",
        fullName: "Lifetime Membership",
        tagline: "Secure Long-Term Growth and Visibility Until 2047.",
        fee: "₹25,000",
        validity: "Till 31 December 2047 (One-time)",
        overview: "Lifetime Membership is designed for entrepreneurs and professionals who want long-term access to IBSEA programs, mentorship, and networking until 2047.",
        highlights: [
            { icon: "calendar_month", text: "Valid Until 2047" },
            { icon: "loyalty", text: "10 Annual Event Passes" }
        ],
        benefits: [
            "10 yearly passes to IBSEA events",
            "50 hours business training annually",
            "Speaking opportunity at events (up to 2 per year)",
            "Magazine story feature",
            "5 strategic consultations annually",
            "Access to mentor network",
            "Invitations to official meetups",
            "Lifetime membership certificate",
            "Exclusive WhatsApp group access",
            "50 promotional posters annually"
        ],
        detailedBenefits: [
            { icon: "auto_awesome", title: "Generational Access", text: "Membership that lasts until 2047, ensuring you're part of India's growth story every step of the way." },
            { icon: "cast_for_education", title: "Thought Leadership", text: "Yearly speaking opportunities at IBSEA events to position yourself as an authority in your field." },
            { icon: "menu_book", title: "Magazine Features", text: "Get your business journey featured in the IBSEA Monthly Magazine distributed to 20,000+ subscribers." },
            { icon: "support_agent", title: "Concierge Mentorship", text: "Priority access to our mentor network for any business challenges throughout your membership." }
        ],
        premiumFeatures: [
            { title: "Annual Consultations", text: "5 strategic one-on-one business consultations annually included at no extra cost." },
            { title: "Personal Branding Arsenal", text: "50 professionally designed promotional posters annually to showcase your achievements." },
            { title: "Sustainability Legacy", text: "IBSEA plants a tree in your name as part of our green initiative for every lifetime member." }
        ],
        stats: [
            { title: "Legacy Community", text: "Be part of an elite circle of 1,000+ visionaries committed to the India @2047 mission." },
            { title: "Peak Efficiency", text: "Save over ₹15 Lakhs in cumulative event fees and training costs over the lifetime of your membership." }
        ],
        eligibility: "Entrepreneurs, professionals, and business owners committed to long-term impact and business excellence.",
        popular: false,
        theme: "gold",
        image: "https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=800"
    }
];
