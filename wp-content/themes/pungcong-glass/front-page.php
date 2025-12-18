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
            <p class="text-slate-600 mt-6 max-w-2xl mx-auto text-lg">
                From precision aluminium works to elegant glass solutions, we deliver comprehensive services tailored to your needs.
            </p>
        </div>
        
        <?php
        $services_query = new WP_Query(array(
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'ASC'
        ));

        if ($services_query->have_posts()) :
            $total_services = $services_query->post_count;
            $idx = 0;
        ?>
        
        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 auto-rows-[280px]">
            <?php
            while ($services_query->have_posts()) : $services_query->the_post();
                $idx++;
                $icon_name = get_post_meta(get_the_ID(), 'icon_name', true);
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $features = get_post_meta(get_the_ID(), 'features', true);
                
                // Dynamic grid sizing for bento effect
                if ($idx === 1) {
                    $grid_class = 'lg:col-span-7 lg:row-span-2'; // Large featured
                } elseif ($idx === 2) {
                    $grid_class = 'lg:col-span-5'; // Medium
                } elseif ($idx === 3) {
                    $grid_class = 'lg:col-span-5'; // Medium  
                } elseif ($idx === 4) {
                    $grid_class = 'lg:col-span-6'; // Half width
                } else {
                    $grid_class = 'lg:col-span-6'; // Half width for additional services
                }
            ?>
            <a href="<?php the_permalink(); ?>" class="group relative overflow-hidden rounded-xl cursor-pointer <?php echo $grid_class; ?> block">
                <!-- Background Image with Overlay -->
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('<?php echo esc_url($image_url); ?>')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-slate-900/20 group-hover:via-slate-900/40 transition-all duration-500"></div>
                
                <!-- Content -->
                <div class="relative h-full p-6 md:p-8 flex flex-col justify-between z-10">
                    <!-- Top: Icon & Badge -->
                    <div class="flex items-start justify-between">
                        <div class="w-14 h-14 bg-amber-600/90 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="<?php echo $icon_name ? esc_attr($icon_name) : 'layers'; ?>" class="w-7 h-7 text-white"></i>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm px-3 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-white text-xs font-medium">View Details</span>
                        </div>
                    </div>
                    
                    <!-- Bottom: Title, Description & Features -->
                    <div>
                        <h3 class="text-2xl <?php echo ($idx === 1) ? 'lg:text-3xl' : ''; ?> font-bold text-white mb-2 group-hover:text-amber-400 transition-colors"><?php the_title(); ?></h3>
                        <p class="text-slate-300 text-sm mb-4 line-clamp-2 <?php echo ($idx === 1) ? 'lg:line-clamp-3 lg:text-base' : ''; ?>"><?php echo get_the_excerpt(); ?></p>
                        
                        <?php if (!empty($features) && is_array($features) && $idx === 1) : ?>
                        <!-- Show features only for first large card -->
                        <div class="hidden lg:flex flex-wrap gap-2 mb-4">
                            <?php 
                            $display_features = array_slice($features, 0, 4);
                            foreach ($display_features as $feature) : ?>
                            <span class="bg-white/10 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full"><?php echo esc_html($feature); ?></span>
                            <?php endforeach; ?>
                            <?php if (count($features) > 4) : ?>
                            <span class="bg-amber-600/80 text-white text-xs px-3 py-1 rounded-full">+<?php echo count($features) - 4; ?> more</span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center text-amber-400 text-xs font-bold tracking-widest uppercase group-hover:translate-x-2 transition-transform">
                            Explore Service <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Corner -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-amber-600/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </a>
            <?php 
            endwhile; 
            ?>
        </div>
        
        <!-- Services Stats Bar -->
        <div class="mt-12 bg-slate-900 rounded-xl p-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="border-r border-slate-700 last:border-0">
                <span class="text-3xl md:text-4xl font-bold text-amber-500"><?php echo $total_services; ?>+</span>
                <p class="text-slate-400 text-sm mt-1">Services Offered</p>
            </div>
            <div class="border-r border-slate-700 last:border-0">
                <span class="text-3xl md:text-4xl font-bold text-amber-500">15+</span>
                <p class="text-slate-400 text-sm mt-1">Years Experience</p>
            </div>
            <div class="border-r border-slate-700 last:border-0">
                <span class="text-3xl md:text-4xl font-bold text-amber-500">500+</span>
                <p class="text-slate-400 text-sm mt-1">Projects Completed</p>
            </div>
            <div>
                <span class="text-3xl md:text-4xl font-bold text-amber-500">100%</span>
                <p class="text-slate-400 text-sm mt-1">Client Satisfaction</p>
            </div>
        </div>
        
        <!-- CTA -->
        <div class="mt-12 text-center">
            <a href="<?php echo esc_url(home_url('/services/')); ?>" class="inline-flex items-center gap-2 px-8 py-4 bg-amber-600 text-white font-bold uppercase tracking-widest text-xs rounded-sm hover:bg-amber-700 transition-all duration-300 transform hover:-translate-y-1 shadow-xl hover:shadow-amber-500/30">
                View All Services <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        
        <?php 
        wp_reset_postdata();
        endif; 
        ?>
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

<?php 
// FAQ Section - Answers questions before contact to reduce friction
get_template_part('template-parts/faq-section', null, array(
    'show_header' => true,
    'bg_class' => 'bg-white',
    'section_id' => 'faq'
)); 
?>

<!-- Integrated Map & Location Section -->
    <section class="relative w-full bg-slate-50 flex flex-col md:block md:h-[650px] sm:pb-0 pb-6">
        
        <!-- Map Container -->
        <div class="w-full h-[400px] md:h-full md:absolute md:inset-0">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.146747530686!2d101.60945761475704!3d3.0553752977751996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb3b2e9ade33b%3A0x47f0779bbd297c10!2sPuchong%20Glass%20Aluminium%20and%20Grill!5e0!3m2!1sen!2smy!4v1625637284921!5m2!1sen!2smy" 
                width="100%" 
                height="100%" 
                style="border: 0; filter: grayscale(100%) contrast(1.2) brightness(0.9);" 
                allowFullScreen="" 
                loading="lazy"
                title="Puchong Glass Location"
                class="w-full h-full object-cover"
            ></iframe>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/10 to-transparent pointer-events-none"></div>
        </div>
        <div class="relative  w-full md:absolute md:top-1/2 md:left-20 md:-translate-y-1/2 md:max-w-md z-10 -mt-6 md:mt-0 px-4 md:px-0">
            <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-slate-900">Visit Our Showroom</h3>
                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Open Today</span>
                </div>
                
                <div class="space-y-8">
                    <!-- Address Item -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center shrink-0 group-hover:bg-amber-100 transition-colors duration-300">
                            <i data-lucide="map-pin" class="text-amber-600 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm mb-1">Our Location</h4>
                            <p class="text-slate-600 leading-relaxed text-sm">
                                Lot 13, Puchong Glass Aluminium & Grill,<br/>
                                Bt 13, Jalan Jurutera, Kampung Seri Aman,<br/>
                                47100 Puchong, Selangor.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Hours Item -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center shrink-0 group-hover:bg-amber-100 transition-colors duration-300">
                            <i data-lucide="clock" class="text-amber-600 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm mb-1">Opening Hours</h4>
                            <p class="text-slate-600 text-sm">Mon - Sat: 9:00 AM - 6:00 PM</p>
                            <p class="text-amber-600 text-sm font-medium mt-1">Sunday: Closed</p>
                        </div>
                    </div>
                    
                    <!-- Contact Item -->
                    <div class="flex items-start gap-4 group">
                        <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center shrink-0 group-hover:bg-amber-100 transition-colors duration-300">
                            <i data-lucide="phone" class="text-amber-600 w-5 h-5"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 text-sm mb-1">Get in Touch</h4>
                            <p class="text-slate-600 text-sm font-medium">+60 12-345 6789</p>
                            <p class="text-slate-400 text-xs mt-1">Available for WhatsApp</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="https://maps.google.com?q=Lot+13+Puchong+Glass+Aluminium+and+Grill" target="_blank" class="flex-1 px-6 py-3.5 rounded-xl font-semibold transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 bg-slate-900 text-white hover:bg-slate-800 shadow-lg hover:shadow-xl">
                        <i data-lucide="navigation" class="w-4 h-4"></i>
                        Get Directions
                    </a>
                    <a href="https://wa.me/60123456789" target="_blank" class="flex-1 px-6 py-3.5 rounded-xl font-semibold transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 bg-amber-500 text-white hover:bg-amber-600 shadow-lg shadow-amber-500/30 hover:shadow-amber-500/40">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php 
// Reusable Contact Section
get_template_part('template-parts/contact-section', null, array(
    'show_header' => true,
    'bg_class' => 'bg-slate-50',
    'section_id' => 'contact'
)); 
?>

<?php get_footer(); ?>
