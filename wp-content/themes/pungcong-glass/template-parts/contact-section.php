<?php
/**
 * Reusable Contact Section Template Part
 * 
 * Usage: get_template_part('template-parts/contact-section');
 * Or with args: get_template_part('template-parts/contact-section', null, array('show_header' => true));
 */

// Default args
$defaults = array(
    'show_header' => true,
    'bg_class' => 'bg-slate-50',
    'section_id' => 'contact'
);

$args = wp_parse_args($args ?? array(), $defaults);
?>

<section id="<?php echo esc_attr($args['section_id']); ?>" class="py-24 <?php echo esc_attr($args['bg_class']); ?>">
    <div class="container mx-auto px-4">
        <?php if ($args['show_header']) : ?>
        <div class="mb-16 text-center">
            <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-600">
                Get In Touch
            </span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight text-slate-900">
                Start Your Project
            </h2>
            <div class="h-1 w-20 bg-amber-600 mt-6 mx-auto"></div>
        </div>
        <?php endif; ?>
        
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <!-- Contact Form -->
            <div class="bg-white p-8 md:p-12 rounded-lg shadow-xl border-t-4 border-amber-600">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Send us a Message</h3>
                <form id="contact-form" class="space-y-6">
                    <?php wp_nonce_field('puchong_contact_nonce', 'contact_nonce'); ?>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Name</label>
                            <input required type="text" name="name" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="Your Name" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Phone</label>
                            <input required type="tel" name="phone" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="+60 12..." />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email (Optional)</label>
                        <input type="email" name="email" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="your@email.com" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Service Needed</label>
                        <select name="service" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors">
                            <option>Aluminium Windows/Doors</option>
                            <option>Security Grill</option>
                            <option>Glass Partition/Shower</option>
                            <option>Renovation/Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Message / Measurements</label>
                        <textarea required name="message" rows="5" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="Please describe your project..."></textarea>
                    </div>
                    <div id="form-message" class="hidden p-4 rounded-sm text-sm font-medium"></div>
                    <button type="submit" id="submit-btn" class="w-full py-4 text-sm px-8 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">
                        <span class="btn-text">Request Free Quote</span>
                        <span class="btn-loading hidden">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="bg-slate-900 text-white p-10 rounded-lg shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-2xl font-bold mb-8 flex items-center gap-3">
                            <i data-lucide="map-pin" class="text-amber-500"></i> Visit Our Workshop
                        </h4>
                        <p class="text-slate-300 mb-8 leading-relaxed text-lg font-light">
                            Lot 13, Puchong Glass Aluminium and Grill,<br/>
                            Bt 13, Jalan Jurutera, Kampung Seri Aman,<br/>
                            47100 Puchong, Selangor.
                        </p>
                        <div class="flex flex-col gap-6 text-sm border-t border-slate-700 pt-8">
                            <div class="flex items-center gap-4">
                                <i data-lucide="phone" size="20" class="text-amber-500"></i>
                                <span class="text-lg">+60 12-345 6789</span>
                            </div>
                            <div class="flex items-center gap-4">
                                <i data-lucide="mail" size="20" class="text-amber-500"></i>
                                <span class="text-lg">sales@puchongglass.com</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-600 p-8 rounded-lg shadow-xl text-white hover:bg-green-700 transition-colors cursor-pointer group" onclick="window.open('https://wa.me/60123456789', '_blank')">
                    <div class="flex justify-between items-center">
                        <div>
                            <h5 class="font-bold flex items-center gap-2 mb-2 text-xl">
                                <i data-lucide="message-circle" class="fill-white text-green-600"></i> WhatsApp Direct
                            </h5>
                            <p class="text-green-100">Send us a photo for an instant estimate.</p>
                        </div>
                        <i data-lucide="arrow-right" class="group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    // Prevent multiple initializations
    if (window.contactFormInitialized) return;
    window.contactFormInitialized = true;
    
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contact-form');
        if (!contactForm) return;
        
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('submit-btn');
            const btnText = btn.querySelector('.btn-text');
            const btnLoading = btn.querySelector('.btn-loading');
            const formMessage = document.getElementById('form-message');
            
            // Show loading
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            btn.disabled = true;
            formMessage.classList.add('hidden');
            
            const formData = new FormData(contactForm);
            formData.append('action', 'puchong_submit_contact');
            
            fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset loading
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                btn.disabled = false;
                
                formMessage.classList.remove('hidden');
                
                if (data.success) {
                    formMessage.className = 'p-4 rounded-sm text-sm font-medium bg-green-100 text-green-800 border border-green-200';
                    formMessage.textContent = data.data;
                    contactForm.reset();
                } else {
                    formMessage.className = 'p-4 rounded-sm text-sm font-medium bg-red-100 text-red-800 border border-red-200';
                    formMessage.textContent = data.data || 'An error occurred. Please try again.';
                }
            })
            .catch(error => {
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                btn.disabled = false;
                
                formMessage.classList.remove('hidden');
                formMessage.className = 'p-4 rounded-sm text-sm font-medium bg-red-100 text-red-800 border border-red-200';
                formMessage.textContent = 'An error occurred. Please try again.';
            });
        });
    });
})();
</script>
