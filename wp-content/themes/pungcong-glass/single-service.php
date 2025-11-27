<?php get_header(); ?>

<div class="pt-32 pb-24 container mx-auto px-4 animate-fade-in-up">
    <?php while (have_posts()) : the_post(); 
        $features = get_post_meta(get_the_ID(), 'features', true);
        $icon_name = get_post_meta(get_the_ID(), 'icon_name', true);
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    ?>

    <a href="<?php echo home_url('/services/'); ?>" class="mb-8 pl-0 hover:bg-transparent hover:text-amber-600 inline-flex items-center text-slate-600 transition-colors">
        <i data-lucide="arrow-left" class="mr-2 w-5 h-5"></i> Back to Services
    </a>

    <div class="grid lg:grid-cols-2 gap-12 items-start">
        <div class="rounded-2xl shadow-2xl overflow-hidden relative group">
            <?php if ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-auto object-cover transition-transform duration-700 group-hover:scale-105" />
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
            <div class="absolute bottom-6 left-6 text-white">
                <span class="bg-amber-600 px-3 py-1 text-xs font-bold uppercase rounded mb-2 inline-block flex items-center gap-2">
                    <i data-lucide="<?php echo esc_attr($icon_name ? $icon_name : 'layers'); ?>" class="w-4 h-4"></i>
                    Service
                </span>
            </div>
        </div>

        <div class="lg:sticky lg:top-32">
            <div class="inline-flex items-center gap-2 text-amber-600 font-bold uppercase tracking-wider text-sm mb-4">
                <i data-lucide="<?php echo esc_attr($icon_name ? $icon_name : 'layers'); ?>" class="w-5 h-5"></i>
                <span>Our Service</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight"><?php the_title(); ?></h1>
            
            <?php if (has_excerpt()) : ?>
            <p class="text-xl text-slate-500 mb-6"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>

            <div class="text-slate-600 leading-relaxed mb-8 text-lg prose prose-lg max-w-none">
                <?php the_content(); ?>
            </div>

            <?php if (!empty($features) && is_array($features)) : ?>
            <h3 class="text-lg font-bold text-slate-900 mb-4 uppercase tracking-wider">What We Offer</h3>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-10">
                <?php foreach ($features as $feature) : ?>
                <li class="flex items-center gap-3 p-4 bg-white border border-slate-100 rounded-lg shadow-sm hover:border-amber-200 transition-colors">
                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 shrink-0"></i>
                    <span class="text-slate-700 font-medium"><?php echo esc_html($feature); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <div class="bg-slate-900 text-white p-8 rounded-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-bold text-2xl mb-2">Interested in this service?</h4>
                    <p class="text-slate-300 mb-6">Let us provide you with a free consultation and quote.</p>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="w-full block text-center px-8 py-3 rounded-none font-bold transition-all duration-300 transform hover:-translate-y-1 tracking-widest uppercase text-xs bg-amber-600 text-white hover:bg-amber-700 shadow-xl hover:shadow-amber-500/30">Get a Free Quote</a>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <i data-lucide="<?php echo esc_attr($icon_name ? $icon_name : 'star'); ?>" class="w-[150px] h-[150px]"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Services Section -->
    <?php
    $related_services = new WP_Query(array(
        'post_type' => 'service',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    if ($related_services->have_posts()) : ?>
    <div class="mt-20 pt-16 border-t border-slate-200">
        <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">Other Services</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <?php while ($related_services->have_posts()) : $related_services->the_post(); 
                $rel_icon = get_post_meta(get_the_ID(), 'icon_name', true);
                $rel_image = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            ?>
            <a href="<?php the_permalink(); ?>" class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="relative h-48 overflow-hidden">
                    <?php if ($rel_image) : ?>
                    <img src="<?php echo esc_url($rel_image); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <i data-lucide="<?php echo esc_attr($rel_icon ? $rel_icon : 'layers'); ?>" class="w-6 h-6"></i>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors"><?php the_title(); ?></h3>
                    <p class="text-slate-500 mt-2 text-sm line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                </div>
            </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
