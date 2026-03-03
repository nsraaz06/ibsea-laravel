/**
 * IBSEA Component Loader
 * Injects header and footer HTML directly to support local file:// access.
 */

const components = {
    header: `
<!-- top navigation   -->
<nav>

<div class="contact-info flex items-center justify-between bg-gray-800 z-999 h-10 text-white px-5">
<div class="flex gap-4 items-center text-sm md:text-md">
<p>
  <i class="fa-solid fa-envelope"></i>
  <a href="mailto:info@example.com">info@example.com</a>
</p>

<p>
  <i class="fa-solid fa-phone"></i>
  <a href="tel:+919876543210">+91 98765 43210</a>
</p>
</div>

<div class="flex gap-4 text-sm md:text-md">
  <a href="#"><i class="fa-brands fa-facebook"></i></a>
  <a href="#"><i class="fa-brands fa-twitter"></i></a>
  <a href="#"><i class="fa-brands fa-instagram"></i></a>
  <a href="#"><i class="fa-brands fa-linkedin"></i></a>
  <a href="#"><i class="fa-brands fa-youtube"></i></a>
</div>
</div>
</nav>


<nav class="primary_nav z-999 bg-white border-default">
    <div class="flex flex-wrap items-center justify-between  px-3 py-2">
        <a href="#" class="flex items-center  rtl:space-x-reverse">
    
            <img src="./ibsea-text-33w-600x83.png.webp" class="h-8 md:h-12" alt="Flowbite Logo" />
        </a>
        <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
            <a href="user_login.php" class="hidden md:block text-white text-heading bg-orange-500 box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded-md text-sm px-4 py-1 hover:scale-110 transition-all duration-300 ease-in-out focus:outline-none">Login</a>
            <a href="user_register.php" class="hidden md:block text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none">
            <img src="./button-registration-1.gif.webp" class="h-8 md:h-12" alt="Flowbite Logo" />
            </a>
            <button data-collapse-toggle="mega-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-lg md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-default" aria-controls="mega-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" bg-white aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
            </button>
        </div>
        <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-6 rtl:space-x-reverse">
                <li>
                    <a href="home.html" class="block py-2 px-3 text-fg-brand border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0" aria-current="page">Home</a>
                </li>
                
                <!-- About Us -->
                <li>
                    <button id="about-dropdown-button" data-dropdown-toggle="about-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        About Us
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div id="about-dropdown" class="absolute z-50 grid hidden w-full md:w-auto text-sm bg-white border border-default rounded-base shadow">
                        <div class="p-4 pb-0 text-heading md:pb-4">
                            <ul class="space-y-3" aria-labelledby="about-dropdown-button">
                                <li><a href="about.html" class="text-body hover:text-fg-brand">Overview & Vision (Viksit Bharat @2047)</a></li>
                                <li><a href="about.html#chairman-message" class="text-body hover:text-fg-brand">Chairman’s Message</a></li>
                                <li><a href="about.html#structure" class="text-body hover:text-fg-brand">Organizational Structure & 21 Councils</a></li>
                                <li><a href="about.html#achievements" class="text-body hover:text-fg-brand">Achievements & Vertical Timeline</a></li>
                                <li><a href="about.html#advisors" class="text-body hover:text-fg-brand">Advisors & Alliance Heads</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Initiatives -->
                <li>
                    <button id="initiatives-dropdown-button" data-dropdown-toggle="initiatives-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        Initiatives
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div id="initiatives-dropdown" class="absolute z-50 grid hidden w-full md:w-auto text-sm bg-white border border-default rounded-base shadow">
                        <div class="p-4 pb-0 text-heading md:pb-4">
                            <ul class="space-y-3" aria-labelledby="initiatives-dropdown-button">
                                <li><a href="#" class="text-body hover:text-fg-brand">India @2047 & Bharat Ke Maharathi</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Vyapar Badhao (Local to Global)</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Center of Excellence (Skill & Innovation)</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Director Mentor Conclave</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Corporate Training Programs</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Growth Exchange Networking</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Membership -->
                <li>
                    <button id="membership-dropdown-button" data-dropdown-toggle="membership-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        Membership
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div id="membership-dropdown" class="absolute z-50 grid hidden w-full md:w-auto text-sm bg-white border border-default rounded-base shadow">
                        <div class="p-4 pb-0 text-heading md:pb-4">
                            <ul class="space-y-3" aria-labelledby="membership-dropdown-button">
                                <li><a href="membership.html" class="text-body font-bold hover:text-fg-brand">Membership Overview</a></li>
                                <li><a href="membership_single.html?plan=booster" class="text-body hover:text-fg-brand">Booster Membership (₹1,999)</a></li>
                                <li><a href="membership_single.html?plan=corporate-booster" class="text-body hover:text-fg-brand">Corporate Booster (₹4,999)</a></li>
                                <li><a href="membership_single.html?plan=corporate-prime" class="text-body hover:text-fg-brand">Corporate Prime (₹1,00,000)</a></li>
                                <li><a href="membership_single.html?plan=lifetime" class="text-body hover:text-fg-brand">Lifetime Membership (₹25,000)</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Knowledge Center -->
                <li>
                    <button id="knowledge-dropdown-button" data-dropdown-toggle="knowledge-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        Knowledge Center
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div id="knowledge-dropdown" class="absolute z-50 grid hidden w-full md:w-auto text-sm bg-white border border-default rounded-base shadow">
                        <div class="p-4 pb-0 text-heading md:pb-4">
                            <ul class="space-y-3" aria-labelledby="knowledge-dropdown-button">
                                <li><a href="#" class="text-body hover:text-fg-brand">Reports & Publications</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Latest Blogs & Updates</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Press Releases & Media Coverage</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Events -->
                <li>
                    <button id="events-dropdown-button" data-dropdown-toggle="events-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">
                        Events
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <div id="events-dropdown" class="absolute z-50 grid hidden w-full md:w-auto text-sm bg-white border border-default rounded-base shadow">
                        <div class="p-4 pb-0 text-heading md:pb-4">
                            <ul class="space-y-3" aria-labelledby="events-dropdown-button">
                                <li><a href="#" class="text-body hover:text-fg-brand">Upcoming Programs & Calendar</a></li>
                                <li><a href="#" class="text-body hover:text-fg-brand">Previous Programs & Highlights</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <!-- Contact Us -->
                <li>
                    <a href="#" class="block py-2 px-3 text-heading border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    `,
    footer: `
<footer class="bg-secondary dark:bg-black text-slate-400 text-sm py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <a href="#" class="flex items-center  rtl:space-x-reverse">
    
            <img src="./ibsea-text-33w-600x83.png.webp" class="h-8 md:h-12" alt="Flowbite Logo" />
        </a>
                </div>
                <p class="mb-4">The leading voice for international business and startups, driving growth through
                    policy, partnership, and innovation.</p>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a class="hover:text-primary transition" href="about.html">About Us</a></li>
                    <li><a class="hover:text-primary transition" href="membership.html">Membership Benefits</a></li>
                    <li><a class="hover:text-primary transition" href="#">Events Calendar</a></li>
                    <li><a class="hover:text-primary transition" href="#">Press Releases</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase mb-4">Resources</h4>
                <ul class="space-y-2">
                    <li><a class="hover:text-primary transition" href="#">Research Reports</a></li>
                    <li><a class="hover:text-primary transition" href="#">Policy Papers</a></li>
                    <li><a class="hover:text-primary transition" href="#">Start-up Toolkit</a></li>
                    <li><a class="hover:text-primary transition" href="#">Global Trade Data</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase mb-4">Contact</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2"><span
                            class="material-symbols-outlined text-primary text-xs">location_on</span> 5, Sansad
                        Marg, New Delhi</li>
                    <li class="flex items-center gap-2"><span
                            class="material-symbols-outlined text-primary text-xs">phone</span> +91 11 4655 0555
                    </li>
                    <li class="flex items-center gap-2"><span
                            class="material-symbols-outlined text-primary text-xs">email</span> info@ibsea.org</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>© 2026 IBSEA. All Rights Reserved.</p>
            <div class="flex gap-4">
                <a class="hover:text-white" href="#">Privacy Policy</a>
                <a class="hover:text-white" href="#">Terms of Use</a>
                <a class="hover:text-white" href="#">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
    `
};

// Injection Logic
function injectComponents() {
    for (const [id, html] of Object.entries(components)) {
        const container = document.getElementById(id);
        if (container) {
            container.innerHTML = html;
            if (id === 'header') updateDarkModeIcon();
        }
    }

    // Render dynamic grids if they exist on the page
    if (document.getElementById('home-membership-grid')) renderMembershipCards('home');
    if (document.getElementById('membership-page-grid')) renderMembershipCards('page');

    // Render single membership details if on that page
    if (document.querySelector('title').textContent.includes('Membership Details')) {
        renderSingleMembership();
    }
}

/**
 * Renders membership cards dynamically from membership-data.js
 * @param {string} context - 'home' or 'page' to determine styling/layout
 */
function renderMembershipCards(context) {
    // Ensure data is available
    if (typeof membershipPlans === 'undefined') {
        console.warn('membershipPlans data not found. Retrying in 100ms...');
        setTimeout(() => renderMembershipCards(context), 100);
        return;
    }

    const homeContainer = document.getElementById('home-membership-grid');
    const pageContainer = document.getElementById('membership-page-grid');
    const container = context === 'home' ? homeContainer : pageContainer;

    if (!container) return;

    let html = '';
    membershipPlans.forEach(plan => {
        const isCorporateBooster = plan.id === 'corporate-booster';

        if (context === 'home') {
            html += generateHomeCard(plan, isCorporateBooster);
        } else {
            html += generatePageCard(plan, isCorporateBooster);
        }
    });

    container.innerHTML = html;
}

/**
 * Renders the single membership detail page based on ?plan=ID URL parameter
 */
function renderSingleMembership() {
    // Ensure data is available
    if (typeof membershipPlans === 'undefined') {
        setTimeout(renderSingleMembership, 100);
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const planId = urlParams.get('plan');

    // Find the plan in our data
    const plan = membershipPlans.find(p => p.id === planId) || membershipPlans.find(p => p.id === 'corporate-booster'); // Default to corporate-booster if not found

    if (!plan) return;

    // 1. Update Title and Meta (Basic)
    document.title = `${plan.fullName} | IBSEA`;

    // 2. Banner Section
    const bannerSection = document.getElementById('plan-banner');
    if (bannerSection) {
        if (plan.theme === 'navy') bannerSection.style.background = 'linear-gradient(135deg, #0f172a 0%, #020617 100%)';
        else if (plan.theme === 'slate') bannerSection.style.background = 'linear-gradient(135deg, #334155 0%, #1e293b 100%)';
        else if (plan.theme === 'gold') bannerSection.style.background = 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)';
        else bannerSection.style.background = 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)';
    }

    const bannerTitle = document.getElementById('plan-title');
    if (bannerTitle) {
        bannerTitle.innerHTML = `${plan.title} <span class="text-gold-accent">Membership</span>`;
    }

    const bannerTagline = document.getElementById('plan-tagline');
    if (bannerTagline) {
        bannerTagline.textContent = plan.tagline;
    }

    const primaryBtn = document.getElementById('plan-btn-primary');
    if (primaryBtn) {
        primaryBtn.textContent = plan.id.includes('corporate') ? 'Register Organization' : 'Join as Individual';
    }

    // 3. Pricing Box
    const tierLabel = document.getElementById('plan-tier-label');
    const popularBadge = document.getElementById('plan-popular-badge');

    if (popularBadge) {
        if (plan.popular) popularBadge.classList.remove('hidden');
        else popularBadge.classList.add('hidden');
    }

    if (tierLabel) {
        if (plan.id === 'booster') tierLabel.textContent = "Associate Tier";
        else if (plan.id === 'corporate-booster') tierLabel.textContent = "Growth Tier";
        else if (plan.id === 'corporate-prime') tierLabel.textContent = "Elite Tier";
        else if (plan.id === 'lifetime') tierLabel.textContent = "Legacy Tier";
    }

    const planFee = document.getElementById('plan-fee');
    if (planFee) planFee.textContent = plan.fee;

    const planValidity = document.getElementById('plan-validity');
    if (planValidity) planValidity.textContent = `per ${plan.validity} Validity`;

    const highlightsContainer = document.getElementById('plan-highlights');
    if (highlightsContainer && plan.highlights) {
        highlightsContainer.innerHTML = plan.highlights.map(h => `
            <div class="flex items-center gap-3 text-slate-200">
                <span class="material-icons text-primary text-sm">${h.icon}</span>
                <span class="text-sm">${h.text}</span>
            </div>
        `).join('');
    }


    // 5. Detailed Benefits Grid
    const benefitsGrid = document.getElementById('plan-detailed-benefits');
    if (benefitsGrid && plan.detailedBenefits) {
        benefitsGrid.innerHTML = plan.detailedBenefits.map(b => `
            <div class="bg-white dark:bg-background-dark p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 hover:border-primary/50 transition-all group">
                <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                    <span class="material-icons text-primary group-hover:text-white">${b.icon}</span>
                </div>
                <h3 class="text-xl font-bold mb-4 text-navy-corp dark:text-white">${b.title}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">${b.text}</p>
            </div>
        `).join('');
    }

    // 5.5 Full Benefits List
    const fullBenefitsGrid = document.getElementById('plan-full-benefits');
    if (fullBenefitsGrid && plan.benefits) {
        fullBenefitsGrid.innerHTML = plan.benefits.map(benefit => `
            <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                <span class="material-icons text-primary text-xl mt-0.5">check_circle</span>
                <span class="text-slate-700 dark:text-slate-300 font-medium">${benefit}</span>
            </div>
        `).join('');
    }

    // 6. Premium Section
    const premiumImage = document.querySelector('section.py-24 img');
    if (premiumImage && plan.image) premiumImage.src = plan.image;

    const premiumTitle = document.getElementById('premium-title');
    if (premiumTitle) premiumTitle.textContent = plan.id.includes('corporate') ? "Elite Corporate Advantages" : "Premium Member Advantages";

    const premiumTagline = document.getElementById('premium-tagline');
    if (premiumTagline) premiumTagline.textContent = `Elevate your ${plan.id.includes('corporate') ? 'organizational' : 'personal'} strategy with bespoke services reserved only for ${plan.title} members.`;

    const premiumFeaturesList = document.getElementById('plan-premium-features');
    if (premiumFeaturesList && plan.premiumFeatures) {
        premiumFeaturesList.innerHTML = plan.premiumFeatures.map(f => `
            <li class="flex items-start gap-4">
                <div class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-gold-accent flex items-center justify-center">
                    <span class="material-icons text-white text-xs">check</span>
                </div>
                <div>
                    <h4 class="font-bold text-navy-corp dark:text-white">${f.title}</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">${f.text}</p>
                </div>
            </li>
        `).join('');
    }

    // 7. Why Join Stats
    const statsGrid = document.getElementById('plan-stats');
    if (statsGrid && plan.stats) {
        statsGrid.innerHTML = plan.stats.map(s => `
            <div>
                <h4 class="text-xl font-bold text-primary mb-3">${s.title}</h4>
                <p class="text-slate-600 dark:text-slate-400">${s.text}</p>
            </div>
        `).join('');
    }

    // 8. Bottom CTA
    const ctaTitle = document.getElementById('cta-title');
    if (ctaTitle) ctaTitle.textContent = plan.id.includes('corporate') ? `Ready to Scale Your Organization?` : `Ready to Grow Your Business?`;

    const ctaTagline = document.getElementById('cta-tagline');
    if (ctaTagline) ctaTagline.textContent = `Join hundreds of successful ${plan.id.includes('corporate') ? 'organizations' : 'members'} already leveraging the IBSEA ${plan.fullName}.`;

    const ctaBtn = document.getElementById('plan-cta-btn');
    if (ctaBtn) {
        ctaBtn.textContent = plan.id.includes('corporate') ? 'Apply Now' : 'Join Today';
    }
}

function generateHomeCard(plan, isFeatured) {
    const borderClass = isFeatured ? 'border-primary' : 'border-slate-200 dark:border-slate-700';
    const shadowClass = isFeatured ? 'shadow-2xl' : 'shadow hover:shadow-xl';
    const transformClass = isFeatured ? 'transform lg:-translate-y-4 z-20' : '';
    const popularBadge = isFeatured ? '<div class="absolute top-0 right-0 bg-primary text-secondary text-[10px] font-bold px-3 py-1 rounded-bl-lg">POPULAR</div>' : '';

    return `
        <div class="bg-white dark:bg-surface-dark p-8 rounded-2xl ${shadowClass} transition duration-300 border-t-4 ${borderClass} relative ${transformClass} flex flex-col">
            ${popularBadge}
            <h3 class="font-bold text-xl ${isFeatured ? 'text-primary' : 'text-secondary dark:text-white'} mb-2">${plan.title.replace(' Membership', '')}</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 h-12">${plan.tagline}</p>
            <div class="text-4xl font-bold text-secondary dark:text-white mb-8">${plan.fee}${plan.validity.includes('Year') ? '<span class="text-sm font-normal text-slate-400">/yr</span>' : ''}</div>
            <ul class="text-sm space-y-3 mb-10 flex-grow text-slate-600 dark:text-slate-300">
                ${plan.benefits.slice(0, 3).map(benefit => `
                    <li class="flex gap-3"><span class="text-primary material-icons text-sm">check_circle</span> ${benefit}</li>
                `).join('')}
            </ul>
            <a href="membership_single.html?plan=${plan.id}" class="w-full py-3 text-center ${isFeatured ? 'bg-primary text-white' : 'border border-secondary text-secondary dark:text-white dark:border-white'} font-bold rounded-lg hover:${isFeatured ? 'bg-orange-600' : 'bg-secondary hover:text-white'} transition ${isFeatured ? 'shadow-lg shadow-primary/20' : ''}">
                ${isFeatured ? 'Join Now' : 'Learn More'}
            </a>
        </div>
    `;
}

function generatePageCard(plan, isFeatured) {
    let bgClass = 'bg-white dark:bg-[#2c2016]';
    let textClass = 'text-secondary dark:text-white';
    let subTextClass = 'text-slate-600 dark:text-slate-300';
    let borderClass = 'border-slate-200 dark:border-slate-800';
    let btnClass = 'bg-slate-100 dark:bg-slate-800 text-secondary dark:text-white hover:bg-primary hover:text-white';
    let iconClass = 'text-primary';

    if (plan.theme === 'navy') {
        bgClass = 'bg-secondary text-white';
        textClass = 'text-white';
        subTextClass = 'text-slate-300';
        borderClass = 'border-white/10';
        btnClass = 'bg-white/10 border border-white/20 text-white hover:bg-white hover:text-secondary';
    } else if (plan.theme === 'primary') {
        borderClass = 'border-2 border-primary';
    } else if (plan.theme === 'gold') {
        iconClass = 'text-gold-accent';
        btnClass = 'border-2 border-gold-accent text-gold-accent hover:bg-gold-accent hover:text-white';
    }

    const popularBadge = isFeatured ? '<div class="absolute top-0 right-0 bg-primary text-white text-[10px] font-black px-3 py-1 rounded-bl-lg">POPULAR</div>' : '';

    return `
        <div id="${plan.id}" class="${bgClass} p-8 rounded-2xl shadow-sm border ${borderClass} hover_lift flex flex-col h-full relative group">
            ${popularBadge}
            <div class="mb-6">
                <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase tracking-wider">${plan.id.split('-')[0]}</span>
                <h3 class="text-2xl font-bold mt-4 ${textClass}">${plan.title}</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm italic mt-1">${plan.tagline}</p>
            </div>
            <div class="mb-8">
                <div class="text-4xl font-black ${textClass}">${plan.fee}</div>
                <div class="text-sm text-slate-400">${plan.validity}</div>
            </div>
            <ul class="space-y-4 text-sm ${subTextClass} mb-10 flex-grow">
                ${plan.benefits.map(benefit => `
                    <li class="flex items-start gap-3">
                        <span class="material-icons ${iconClass} text-lg">${plan.theme === 'gold' ? 'verified' : 'check_circle'}</span>
                        <span>${benefit}</span>
                    </li>
                `).join('')}
            </ul>
            <a href="membership_single.html?plan=${plan.id}" class="w-full py-4 ${btnClass} font-bold rounded-xl transition-all text-center">Join Now</a>
        </div>
    `;
}

// Injection Logic
function injectComponents() {
    // Only render grids and specific page elements
    // Header/Footer are now handled by PHP
    if (document.getElementById('home-membership-grid')) renderMembershipCards('home');
    if (document.getElementById('membership-page-grid')) renderMembershipCards('page');

    if (document.querySelector('title').textContent.includes('Membership Details')) {
        renderSingleMembership();
    }
}

// Global Click Handler (Disabled legacy mobile menu/theme logic as it's now in header.php)
document.addEventListener('click', (e) => {
    // We keep this for any other non-header UI logic if needed, but mobile menu is in header.php
});

// Initialize Theme on Load (Moved to header.php for faster execution)
// (function initTheme() { ... })();

// Inject on DOM load
document.addEventListener('DOMContentLoaded', injectComponents);
if (document.readyState === "complete" || document.readyState === "interactive") {
    injectComponents();
}
