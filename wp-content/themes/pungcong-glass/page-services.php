<?php
/* Template Name: Services Page */
get_header(); 
?>

<div class="pt-24 pb-24">
    <div class="bg-slate-900 text-white py-20 mb-16 relative overflow-hidden">
       <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-20"></div>
       <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-5xl font-bold mb-4">Our Expertise</h1>
        <p class="text-xl text-slate-300 max-w-2xl mx-auto">Comprehensive glass, aluminium, and grill solutions tailored for Malaysian homes.</p>
      </div>
    </div>
    
    <div class="container mx-auto px-4 space-y-24">
      <?php
      $services_query = new WP_Query(array(
          'post_type' => 'service',
          'posts_per_page' => -1,
          'orderby' => 'date',
          'order' => 'ASC'
      ));

      if ($services_query->have_posts()) :
          $index = 0;
          while ($services_query->have_posts()) : $services_query->the_post();
              $index++;
              $features = get_post_meta(get_the_ID(), 'features', true);
              $icon_name = get_post_meta(get_the_ID(), 'icon_name', true);
              $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
              $reverse_class = ($index % 2 === 0) ? 'lg:flex-row-reverse' : '';
              $service_link = get_permalink();
      ?>
        <div class="flex flex-col lg:flex-row gap-12 items-center <?php echo $reverse_class; ?>">
          <div class="w-full lg:w-1/2">
            <a href="<?php echo esc_url($service_link); ?>" class="block relative rounded-lg overflow-hidden shadow-2xl group cursor-pointer">
               <div class="absolute inset-0 bg-amber-600/0 group-hover:bg-amber-600/10 transition-colors z-10"></div>
               <?php if ($image_url) : ?>
               <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-80 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105" />
               <?php endif; ?>
               <!-- View Details Overlay -->
               <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                   <span class="bg-amber-600 text-white px-6 py-3 rounded-sm font-bold uppercase tracking-wider text-xs flex items-center gap-2 shadow-lg">
                       View Details <i data-lucide="arrow-right" class="w-4 h-4"></i>
                   </span>
               </div>
            </a>
          </div>
          <div class="w-full lg:w-1/2">
            <a href="<?php echo esc_url($service_link); ?>" class="inline-flex items-center gap-2 text-amber-600 font-bold uppercase tracking-wider text-sm mb-4 hover:text-amber-700 transition-colors">
              <i data-lucide="<?php echo $icon_name ? esc_attr($icon_name) : 'layers'; ?>" class="w-5 h-5"></i>
              <span><?php the_title(); ?></span>
            </a>
            <a href="<?php echo esc_url($service_link); ?>" class="block group">
                <h2 class="text-3xl font-bold text-slate-900 mb-6 group-hover:text-amber-600 transition-colors"><?php the_title(); ?></h2>
            </a>
            <div class="text-slate-600 text-lg leading-relaxed mb-8">
                <?php the_content(); ?>
            </div>
            <?php if (!empty($features) && is_array($features)) : ?>
            <div class="grid grid-cols-2 gap-4 mb-8">
              <?php foreach ($features as $feature) : ?>
                <div class="flex items-center gap-2 text-slate-700">
                  <i data-lucide="check-circle" class="text-amber-600 w-5 h-5 shrink-0"></i>
                  <span class="text-sm font-medium"><?php echo esc_html($feature); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            
            <!-- Call to Action Button -->
            <a href="<?php echo esc_url($service_link); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white font-bold uppercase tracking-widest text-xs rounded-sm hover:bg-amber-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-amber-500/30">
                Learn More <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
          </div>
        </div>
      <?php 
          endwhile; 
          wp_reset_postdata();
      endif; 
      ?>
    </div>
</div>

<?php get_footer(); ?>
