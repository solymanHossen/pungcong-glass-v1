<?php
/* Template Name: Contact Page */
get_header(); 
?>

<div class="pt-24 pb-24 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="mb-16 text-center">
            <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-600">
                Get In Touch
            </span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight text-slate-900">
                Start Your Project
            </h2>
            <div class="h-1 w-20 bg-amber-600 mt-6 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-start">
            <div class="bg-white p-8 md:p-12 rounded-lg shadow-xl border-t-4 border-amber-600">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Send us a Message</h3>
                <form class="space-y-6" action="#" method="POST">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Name</label>
                            <input required type="text" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="Your Name" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Phone</label>
                            <input required type="tel" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="+60 12..." />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Service Needed</label>
                        <select class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors">
                            <option>Aluminium Windows/Doors</option>
                            <option>Security Grill</option>
                            <option>Glass Partition/Shower</option>
                            <option>Renovation/Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Message / Measurements</label>
                        <textarea required rows="5" class="w-full p-4 bg-slate-50 border border-slate-200 focus:border-amber-600 focus:outline-none focus:ring-1 focus:ring-amber-600 rounded-sm transition-colors" placeholder="Please describe your project..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-4 text-sm px-8 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">
                        Request Free Quote
                    </button>
                </form>
            </div>

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
</div>

<?php get_footer(); ?>
