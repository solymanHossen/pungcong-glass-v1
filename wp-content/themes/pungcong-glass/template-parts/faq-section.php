<?php
/**
 * Modern FAQ Section Template Part
 * 
 * Usage: get_template_part('template-parts/faq-section');
 * Or with args: get_template_part('template-parts/faq-section', null, array('show_header' => true));
 */

// Default args
$defaults = array(
    'show_header' => true,
    'bg_class' => 'bg-white',
    'section_id' => 'faq'
);

$args = wp_parse_args($args ?? array(), $defaults);

// FAQ Data - Can be customized or fetched from database/ACF
$faqs = array(
    array(
        'question' => 'What types of aluminium and glass services do you offer?',
        'answer' => 'We provide comprehensive solutions including aluminium windows and doors, sliding systems, folding doors, glass partitions, shower screens, security grills, and complete renovation services. Each project is custom-designed to match your architectural vision and functional requirements.'
    ),
    array(
        'question' => 'How long does a typical installation project take?',
        'answer' => 'Project timelines vary based on scope and complexity. Standard window and door installations typically take 1-2 weeks from measurement to completion. Larger projects like full home renovations may take 4-8 weeks. We provide detailed timelines during our free consultation.'
    ),
    array(
        'question' => 'Do you provide free quotations and site visits?',
        'answer' => 'Yes, we offer complimentary site visits and detailed quotations for all projects in Puchong and surrounding areas. Our expert team will assess your space, discuss your requirements, and provide a transparent, no-obligation quote within 24-48 hours.'
    ),
    array(
        'question' => 'What warranty do you offer on your products and installation?',
        'answer' => 'We stand behind our craftsmanship with a comprehensive warranty package. All aluminium frames come with a 10-year structural warranty, glass products with 5-year coverage, and our installation workmanship is guaranteed for 2 years. Extended warranty options are available.'
    ),
    array(
        'question' => 'Can you match specific designs or architectural styles?',
        'answer' => 'Absolutely. Our team specializes in custom fabrication to match any architectural style—from contemporary minimalist to classic traditional designs. We work with powder-coated aluminium in various colors and textures, and can source specialized glass types including tinted, frosted, and laminated options.'
    ),
    array(
        'question' => 'What areas do you serve in Malaysia?',
        'answer' => 'We are based in Puchong, Selangor and serve the entire Klang Valley including Kuala Lumpur, Petaling Jaya, Subang Jaya, Shah Alam, and surrounding areas. For larger projects, we also take on assignments throughout Peninsular Malaysia.'
    )
);
?>

<section id="<?php echo esc_attr($args['section_id']); ?>" class="py-24 lg:py-32 <?php echo esc_attr($args['bg_class']); ?> relative overflow-hidden">
    <!-- Luxury Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-bl from-amber-50/50 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-gradient-to-tr from-slate-100/80 to-transparent"></div>
        <!-- Elegant geometric pattern -->
        <div class="absolute top-20 left-10 w-72 h-72 border border-amber-200/30 rounded-full opacity-40"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 border border-slate-200/50 rounded-full opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <?php if ($args['show_header']) : ?>
        <div class="mb-16 lg:mb-20 text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 font-bold tracking-[0.2em] text-xs uppercase mb-4 text-amber-600">
                <span class="w-8 h-px bg-amber-600"></span>
                Questions & Answers
                <span class="w-8 h-px bg-amber-600"></span>
            </span>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold leading-tight text-slate-900 mb-6">
                Frequently Asked <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-amber-500">Questions</span>
            </h2>
            <p class="text-slate-500 text-lg md:text-xl font-light leading-relaxed">
                Find answers to common questions about our services, process, and commitment to excellence.
            </p>
        </div>
        <?php endif; ?>
        
        <div class="max-w-4xl mx-auto">
            <!-- FAQ Accordion -->
            <div class="space-y-4" id="faq-accordion">
                <?php foreach ($faqs as $index => $faq) : ?>
                <div class="faq-item group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 hover:border-amber-200/50 overflow-hidden" data-faq-index="<?php echo $index; ?>">
                    <!-- Question Button -->
                    <button class="faq-trigger w-full text-left p-6 md:p-8 flex items-center justify-between gap-6 transition-colors duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2" aria-expanded="false" aria-controls="faq-answer-<?php echo $index; ?>">
                        <div class="flex items-center gap-5">
                            <!-- Number Badge -->
                            <span class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-slate-100 to-slate-50 group-hover:from-amber-100 group-hover:to-amber-50 rounded-xl flex items-center justify-center font-bold text-slate-400 group-hover:text-amber-600 transition-all duration-300 text-sm md:text-base shadow-sm">
                                <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            </span>
                            <h3 class="text-base md:text-lg font-semibold text-slate-800 group-hover:text-slate-900 transition-colors duration-300 leading-snug">
                                <?php echo esc_html($faq['question']); ?>
                            </h3>
                        </div>
                        <!-- Toggle Icon -->
                        <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-slate-100 group-hover:bg-amber-600 rounded-full flex items-center justify-center transition-all duration-300 shadow-sm">
                            <svg class="faq-icon w-5 h-5 md:w-6 md:h-6 text-slate-500 group-hover:text-white transition-all duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path class="faq-icon-plus" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12"></path>
                                <path class="faq-icon-minus hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h12"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <!-- Answer Panel -->
                    <div id="faq-answer-<?php echo $index; ?>" class="faq-content overflow-hidden transition-all duration-500 ease-out" style="max-height: 0;">
                        <div class="px-6 md:px-8 pb-6 md:pb-8 pt-0">
                            <div class="pl-15 md:pl-17 ml-0 md:ml-[68px] border-l-2 border-amber-200 pl-6">
                                <p class="text-slate-600 leading-relaxed text-base md:text-lg font-light">
                                    <?php echo esc_html($faq['answer']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bottom CTA Card -->
            <div class="mt-12 lg:mt-16 relative">
                <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-3xl p-8 md:p-12 text-center overflow-hidden relative">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-600/5 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-600/20 rounded-2xl mb-6">
                            <i data-lucide="message-circle-question" class="w-8 h-8 text-amber-500"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">
                            Still Have Questions?
                        </h3>
                        <p class="text-slate-400 text-lg mb-8 max-w-lg mx-auto font-light">
                            Our expert team is ready to provide personalized answers and guidance for your project.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="<?php echo home_url('/contact'); ?>" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-amber-600 hover:bg-amber-500 text-white font-bold text-sm uppercase tracking-widest rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/25">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                                Contact Us
                            </a>
                            <a href="https://wa.me/60123456789" target="_blank" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold text-sm uppercase tracking-widest rounded-xl transition-all duration-300 hover:-translate-y-1 border border-white/20 hover:border-white/40 backdrop-blur-sm">
                                <i data-lucide="message-circle" class="w-5 h-5"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* FAQ Accordion Styles */
.faq-item.active .faq-trigger {
    background-color: rgba(251, 191, 36, 0.05);
}

.faq-item.active .faq-icon {
    transform: rotate(180deg);
}

.faq-item.active .faq-icon-plus {
    display: none;
}

.faq-item.active .faq-icon-minus {
    display: block;
}

.faq-item.active .faq-trigger > div:first-child > span:first-child {
    background: linear-gradient(to bottom right, rgb(254, 243, 199), rgb(253, 230, 138));
    color: rgb(180, 83, 9);
}

.faq-item.active .faq-trigger > div:last-child {
    background-color: rgb(217, 119, 6);
}

.faq-item.active .faq-trigger > div:last-child svg {
    color: white;
}

/* Smooth content reveal */
.faq-content {
    will-change: max-height;
}

/* Focus styles for accessibility */
.faq-trigger:focus-visible {
    outline: none;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.3);
    border-radius: 1rem;
}

/* Hover lift effect */
.faq-item:hover {
    transform: translateY(-2px);
}

/* Custom spacing for answer text */
@media (min-width: 768px) {
    .faq-content .pl-15 {
        padding-left: 1.5rem;
    }
}
</style>

<script>
(function() {
    // Prevent multiple initializations
    if (window.faqAccordionInitialized) return;
    window.faqAccordionInitialized = true;
    
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(function(item) {
            const trigger = item.querySelector('.faq-trigger');
            const content = item.querySelector('.faq-content');
            
            if (!trigger || !content) return;
            
            trigger.addEventListener('click', function() {
                const isActive = item.classList.contains('active');
                
                // Close all other items (accordion behavior)
                faqItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        const otherContent = otherItem.querySelector('.faq-content');
                        const otherTrigger = otherItem.querySelector('.faq-trigger');
                        if (otherContent) otherContent.style.maxHeight = '0';
                        if (otherTrigger) otherTrigger.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Toggle current item
                if (isActive) {
                    item.classList.remove('active');
                    content.style.maxHeight = '0';
                    trigger.setAttribute('aria-expanded', 'false');
                } else {
                    item.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                    trigger.setAttribute('aria-expanded', 'true');
                }
            });
            
            // Handle keyboard navigation
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    trigger.click();
                }
            });
        });

        // Re-initialize Lucide icons if available
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
})();
</script>
