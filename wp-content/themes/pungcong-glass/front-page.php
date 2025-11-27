<?php get_header(); ?>

<!-- Hero -->
<section id="home" class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden bg-slate-900">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/80 to-slate-900/50 z-10"></div>
        <div class="w-full h-full bg-[url('https://images.unsplash.com/photo-1600607686527-6fb886090705?auto=format&fit=crop&q=80')] bg-cover bg-center animate-slow-zoom"></div>
    </div>
    <div class="container mx-auto px-4 relative z-20 pt-10">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/20 px-4 py-2 rounded-full mb-8 backdrop-blur-md animate-fade-in-up">
                <i data-lucide="star" class="w-3 h-3 text-amber-400 fill-amber-400"></i>
                <span class="text-white text-xs font-bold tracking-widest uppercase">Premium Craftsmanship in Puchong</span>
            </div>
            <h1 class="text-5xl md:text-8xl font-bold text-white leading-[1.1] mb-8 animate-fade-in-up delay-100">
                Precision <span class="text-transparent bg-clip-text bg-gradient-to-br from-amber-200 to-amber-600">Glass.</span><br/>
                Enduring <span class="text-slate-400">Metal.</span>
            </h1>
            <p class="text-slate-300 text-lg md:text-xl mb-12 max-w-2xl leading-relaxed animate-fade-in-up delay-200 font-light border-l-4 border-amber-600 pl-6">
                Elevate your property with Malaysia's finest aluminium and glass architectural solutions. Secure, stylish, and built to last.
            </p>
            <div class="flex flex-col sm:flex-row gap-5 animate-fade-in-up delay-300">
                <a href="<?php echo home_url('/contact'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">
                    Get Free Quote
                </a>
                <a href="<?php echo home_url('/gallery'); ?>" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-transparent border-2 border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white text-white border-white hover:bg-white hover:text-slate-900 hover:border-white">
                    View Masterpieces
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-white/50 animate-bounce flex flex-col items-center gap-2 z-20">
        <span class="text-[10px] uppercase tracking-widest">Scroll</span>
        <i data-lucide="arrow-down" size="20"></i>
    </div>
</section>

<!-- Modern Services Grid (Bento Style) -->
<section id="services" class="py-24 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="mb-16 text-center">
            <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-600">
                Our Expertise
            </span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight text-slate-900">
                Tailored Architectural Solutions
            </h2>
            <div class="h-1 w-20 bg-amber-600 mt-6 mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 h-auto lg:h-[500px]">
            <?php
            $services_query = new WP_Query(array(
                'post_type' => 'service',
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'ASC'
            ));

            if ($services_query->have_posts()) :
                $idx = 0;
                while ($services_query->have_posts()) : $services_query->the_post();
                    $idx++;
                    $is_large = ($idx === 1 || $idx === 4);
                    $bg_class = $is_large ? 'lg:col-span-2 bg-slate-800' : 'bg-white';
                    $icon_name = get_post_meta(get_the_ID(), 'icon_name', true);
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <div class="group relative overflow-hidden rounded-sm cursor-pointer <?php echo $bg_class; ?>" onclick="window.location.href='<?php the_permalink(); ?>'">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 opacity-40 group-hover:opacity-30" style="background-image: url('<?php echo $image_url; ?>')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-90"></div>
                
                <div class="relative h-full p-8 flex flex-col justify-end z-10">
                    <i data-lucide="<?php echo $icon_name ? $icon_name : 'layers'; ?>" class="w-10 h-10 text-amber-500 mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-2"><?php the_title(); ?></h3>
                    <p class="text-slate-300 text-sm mb-6 line-clamp-2"><?php echo get_the_content(); ?></p>
                    <div class="flex items-center text-amber-500 text-xs font-bold tracking-widest uppercase group-hover:translate-x-2 transition-transform">
                        Explore <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                    </div>
                </div>
            </div>
            <?php 
                endwhile; 
                wp_reset_postdata();
            endif; 
            ?>
        </div>
    </div>
</section>

<!-- Featured Projects Showcase -->
<section id="gallery" class="py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div class="text-left">
                <span class="text-amber-600 font-bold tracking-[0.2em] text-xs uppercase mb-3 block">Selected Works</span>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900">Recent Masterpieces</h2>
            </div>
            <a href="<?php echo home_url('/gallery'); ?>" class="mt-6 md:mt-0 px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-transparent border-2 border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white">View Full Gallery</a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php
            $projects_query = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 3
            ));

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    $cats = get_the_terms(get_the_ID(), 'project_category');
                    $cat_name = !empty($cats) ? $cats[0]->name : 'Project';
                    $location = get_post_meta(get_the_ID(), 'location', true);
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
            <div class="group cursor-pointer" onclick="window.location.href='<?php the_permalink(); ?>'">
                <div class="relative h-80 overflow-hidden rounded-lg mb-6">
                    <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-slate-900/0 transition-all z-10"></div>
                    <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-3 rounded-full z-20 opacity-0 group-hover:opacity-100 transition-all translate-y-4 group-hover:translate-y-0">
                        <i data-lucide="arrow-right" class="w-5 h-5 text-amber-600"></i>
                    </div>
                </div>
                <p class="text-amber-600 text-xs font-bold uppercase tracking-wider mb-2"><?php echo $cat_name; ?></p>
                <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors"><?php the_title(); ?></h3>
                <p class="text-slate-500 text-sm mt-2"><?php echo $location; ?></p>
            </div>
            <?php 
                endwhile; 
                wp_reset_postdata();
            endif; 
            ?>
        </div>
    </div>
</section>

<!-- "Why Choose Us" - Visual Section -->
<section id="why-us" class="relative py-24 bg-slate-900 overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-slate-800/30 skew-x-12 translate-x-32"></div>
    <div class="absolute bottom-0 left-0 w-1/3 h-full bg-amber-600/5 skew-x-12 -translate-x-32"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-16 text-left">
                    <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-400">
                        The Puchong Glass Standard
                    </span>
                    <h2 class="text-3xl md:text-5xl font-bold leading-tight text-white">
                        Why We Lead The Industry
                    </h2>
                    <div class="h-1 w-20 bg-amber-600 mt-6"></div>
                </div>
                <p class="text-slate-400 text-lg mb-10 leading-relaxed">
                    We don't just build; we engineer solutions. With over 15 years of experience in Puchong, we combine traditional craftsmanship with modern technology to deliver results that stand the test of time.
                </p>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-amber-600/20 rounded-full flex items-center justify-center shrink-0 border border-amber-600/30">
                            <i data-lucide="check-circle" class="text-amber-500 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">Direct Factory Fabrication</h4>
                            <p class="text-slate-400 text-sm mt-1">No middle-men. We fabricate everything in our Puchong workshop for quality control and better pricing.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-amber-600/20 rounded-full flex items-center justify-center shrink-0 border border-amber-600/30">
                            <i data-lucide="check-circle" class="text-amber-500 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">Premium Material Guarantee</h4>
                            <p class="text-slate-400 text-sm mt-1">We only use certified grade aluminium and impact-resistant tempered glass.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-amber-600/20 rounded-full flex items-center justify-center shrink-0 border border-amber-600/30">
                            <i data-lucide="check-circle" class="text-amber-500 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">On-Time Delivery</h4>
                            <p class="text-slate-400 text-sm mt-1">Your time is valuable. We stick to the schedule we promise.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 pt-8 border-t border-slate-800 flex gap-12">
                    <div>
                        <span class="text-4xl font-bold text-white block">15+</span>
                        <span class="text-amber-500 text-xs uppercase tracking-wider">Years Experience</span>
                    </div>
                    <div>
                        <span class="text-4xl font-bold text-white block">500+</span>
                        <span class="text-amber-500 text-xs uppercase tracking-wider">Happy Homes</span>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1590333290636-6c92d547d06e?auto=format&fit=crop&q=80" alt="Worker" class="rounded-lg shadow-2xl translate-y-8" />
                    <img src="https://images.unsplash.com/photo-1595846519845-68e298c2edd8?auto=format&fit=crop&q=80" alt="Material" class="rounded-lg shadow-2xl" />
                </div>
                <!-- Floating Badge -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-amber-600 p-6 rounded-full shadow-xl text-white text-center w-32 h-32 flex flex-col items-center justify-center border-4 border-slate-900">
                    <i data-lucide="star" class="fill-white mb-1 w-6 h-6"></i>
                    <span class="font-bold text-sm leading-none">Top Rated</span>
                    <span class="text-[10px] mt-1">in Selangor</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Integrated Map & Location Section -->
<section class="relative h-[600px] w-full bg-slate-200">
    <!-- Full Width Map Iframe -->
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.146747530686!2d101.60945761475704!3d3.0553752977751996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb3b2e9ade33b%3A0x47f0779bbd297c10!2sPuchong%20Glass%20Aluminium%20and%20Grill!5e0!3m2!1sen!2smy!4v1625637284921!5m2!1sen!2smy" 
        width="100%" 
        height="100%" 
        style="border: 0; filter: grayscale(0.3);" 
        allowFullScreen="" 
        loading="lazy"
        title="Puchong Glass Location"
    ></iframe>

    <!-- Floating Contact Card Overlay -->
    <div class="absolute top-1/2 left-4 md:left-20 -translate-y-1/2 bg-white p-8 md:p-10 shadow-2xl rounded-sm max-w-md w-full border-l-4 border-amber-600">
        <h3 class="text-2xl font-bold text-slate-900 mb-6">Visit Our Showroom</h3>
        <div class="space-y-6">
            <div class="flex items-start gap-4">
                <i data-lucide="map-pin" class="text-amber-600 w-6 h-6 shrink-0 mt-1"></i>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase mb-1">Address</h4>
                    <p class="text-slate-600 leading-relaxed text-sm">
                        Lot 13, Puchong Glass Aluminium & Grill,<br/>
                        Bt 13, Jalan Jurutera, Kampung Seri Aman,<br/>
                        47100 Puchong, Selangor.
                    </p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <i data-lucide="clock" class="text-amber-600 w-6 h-6 shrink-0 mt-1"></i>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase mb-1">Opening Hours</h4>
                    <p class="text-slate-600 text-sm">Mon - Sat: 9:00 AM - 6:00 PM</p>
                    <p class="text-amber-600 text-sm font-semibold">Sunday: Closed</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <i data-lucide="phone" class="text-amber-600 w-6 h-6 shrink-0 mt-1"></i>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase mb-1">Contact</h4>
                    <p class="text-slate-600 text-sm">+60 12-345 6789</p>
                </div>
            </div>
        </div>
        <div class="mt-8 flex gap-3">
            <a href="https://maps.google.com?q=Lot+13+Puchong+Glass+Aluminium+and+Grill" target="_blank" class="flex-1 px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">
                Get Directions
            </a>
            <a href="https://wa.me/60123456789" target="_blank" class="px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs flex items-center justify-center gap-2 bg-transparent border-2 border-amber-600 text-amber-600 hover:bg-amber-600 hover:text-white">
                WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-24 bg-slate-50">
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
</section>

<?php get_footer(); ?>
