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
      ?>
        <div class="flex flex-col lg:flex-row gap-12 items-center <?php echo $reverse_class; ?>">
          <div class="w-full lg:w-1/2">
            <div class="relative rounded-lg overflow-hidden shadow-2xl group">
               <div class="absolute inset-0 bg-amber-600/0 group-hover:bg-amber-600/10 transition-colors z-10"></div>
               <?php if ($image_url) : ?>
               <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" class="w-full h-80 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105" />
               <?php endif; ?>
            </div>
          </div>
          <div class="w-full lg:w-1/2">
            <div class="inline-flex items-center gap-2 text-amber-600 font-bold uppercase tracking-wider text-sm mb-4">
              <i data-lucide="<?php echo $icon_name ? $icon_name : 'layers'; ?>" class="w-5 h-5"></i>
              <span><?php the_title(); ?></span>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 mb-6"><?php the_title(); ?></h2>
            <div class="text-slate-600 text-lg leading-relaxed mb-8">
                <?php the_content(); ?>
            </div>
            <?php if (!empty($features) && is_array($features)) : ?>
            <div class="grid grid-cols-2 gap-4">
              <?php foreach ($features as $feature) : ?>
                <div class="flex items-center gap-2 text-slate-700">
                  <i data-lucide="check-circle" class="text-amber-600 w-5 h-5 shrink-0"></i>
                  <span class="text-sm font-medium"><?php echo $feature; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
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
