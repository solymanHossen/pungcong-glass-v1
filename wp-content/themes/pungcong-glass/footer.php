</main><!-- #main-content -->

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-900" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-amber-600 text-white flex items-center justify-center font-bold text-lg rounded-sm" aria-hidden="true">P</div>
                        <span class="text-white font-bold text-lg tracking-wider">PUCHONG GLASS</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-6 text-slate-500">
                        Your premier partner for aluminium and glass architectural solutions in Selangor. Combining aesthetics with security since 2008.
                    </p>
                    <div class="flex gap-4">
                        <a href="https://facebook.com/puchongglass" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Facebook" class="w-8 h-8 bg-slate-900 rounded flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                        <a href="https://instagram.com/puchongglass" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Instagram" class="w-8 h-8 bg-slate-900 rounded flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                    </div>
                </div>

                <nav aria-label="Footer navigation">
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Site Links</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?php echo home_url('/services'); ?>" class="hover:text-amber-500 transition-colors">Services</a></li>
                        <li><a href="<?php echo home_url('/gallery'); ?>" class="hover:text-amber-500 transition-colors">Portfolio</a></li>
                        <li><a href="<?php echo home_url('/why-us'); ?>" class="hover:text-amber-500 transition-colors">Why Us</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>" class="hover:text-amber-500 transition-colors">Get Quote</a></li>
                    </ul>
                </nav>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Expertise</h4>
                    <ul class="space-y-3 text-sm">
                        <li><span class="text-slate-500 hover:text-slate-300">Aluminium Bi-Fold Doors</span></li>
                        <li><span class="text-slate-500 hover:text-slate-300">Tempered Glass Works</span></li>
                        <li><span class="text-slate-500 hover:text-slate-300">Security Grills</span></li>
                        <li><span class="text-slate-500 hover:text-slate-300">Polycarbonate Awnings</span></li>
                    </ul>
                </div>

                <div itemscope itemtype="https://schema.org/LocalBusiness">
                    <meta itemprop="name" content="Puchong Glass Aluminium and Grill">
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Working Hours</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between border-b border-slate-900 pb-2"><span>Mon - Fri:</span> <time itemprop="openingHours" datetime="Mo-Fr 09:00-18:00" class="text-white">9:00 AM - 6:00 PM</time></li>
                        <li class="flex justify-between border-b border-slate-900 pb-2"><span>Saturday:</span> <time itemprop="openingHours" datetime="Sa 09:00-15:00" class="text-white">9:00 AM - 3:00 PM</time></li>
                        <li class="flex justify-between pt-2"><span>Sunday:</span> <span class="text-amber-600 font-bold">Closed</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-900 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-slate-600">
                <p>&copy; <?php echo date('Y'); ?> Puchong Glass Aluminium and Grill. All rights reserved.</p>
                <p class="mt-2 md:mt-0 flex items-center gap-1">Designed for Excellence in <span class="text-amber-600">Selangor, Malaysia</span></p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a 
        href="https://wa.me/60123456789" 
        target="_blank" 
        rel="noopener noreferrer"
        aria-label="Chat with us on WhatsApp"
        class="fixed bottom-6 right-6 z-50 bg-green-500 text-white p-4 rounded-full shadow-2xl hover:bg-green-600 hover:-translate-y-2 transition-all flex items-center justify-center group"
    >
        <i data-lucide="message-circle" class="w-8 h-8" aria-hidden="true"></i>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs group-hover:ml-3 transition-all duration-300 font-bold">Chat on WhatsApp</span>
    </a>

    <?php wp_footer(); ?>
</body>
</html>