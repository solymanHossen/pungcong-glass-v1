<?php
/* Template Name: Gallery Page */
get_header(); 
?>

<div class="pt-24 pb-24 bg-slate-50">
    <div class="container mx-auto px-4">
        <div class="mb-16 text-center">
            <span class="font-bold tracking-[0.2em] text-xs uppercase mb-3 block text-amber-600">
                Portfolio
            </span>
            <h2 class="text-3xl md:text-5xl font-bold leading-tight text-slate-900">
                Our Works Gallery
            </h2>
            <div class="h-1 w-20 bg-amber-600 mt-6 mx-auto"></div>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-16" id="gallery-filters">
            <button data-filter="all" class="filter-btn px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-slate-900 text-white shadow-lg scale-105">All</button>
            <button data-filter="aluminium" class="filter-btn px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-white text-slate-500 hover:bg-slate-200 border border-slate-100">Aluminium</button>
            <button data-filter="glass" class="filter-btn px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-white text-slate-500 hover:bg-slate-200 border border-slate-100">Glass</button>
            <button data-filter="grill" class="filter-btn px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-white text-slate-500 hover:bg-slate-200 border border-slate-100">Grill</button>
            <button data-filter="renovation" class="filter-btn px-8 py-3 rounded-full text-xs font-bold uppercase tracking-widest transition-all bg-white text-slate-500 hover:bg-slate-200 border border-slate-100">Renovation</button>
        </div>

        <!-- Masonry-style Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="gallery-grid">
            <?php
            $projects_query = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => -1
            ));

            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    $cats = get_the_terms(get_the_ID(), 'project_category');
                    $cat_slug = !empty($cats) ? strtolower($cats[0]->name) : 'other';
                    $cat_name = !empty($cats) ? $cats[0]->name : 'Project';
                    $location = get_post_meta(get_the_ID(), 'location', true);
                    $date = get_post_meta(get_the_ID(), 'project_date', true);
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
            <div class="gallery-item group cursor-pointer bg-white rounded-lg shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden" data-category="<?php echo $cat_slug; ?>" onclick="window.location.href='<?php the_permalink(); ?>'">
              <div class="h-72 w-full relative overflow-hidden">
                 <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-slate-900/0 transition-colors z-10"></div>
                 <?php if ($image_url) : ?>
                 <img src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                 <?php endif; ?>
                 
                 <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded text-xs font-bold uppercase text-slate-900 z-20">
                   <?php echo $cat_name; ?>
                 </div>
              </div>
              
              <div class="p-8 relative">
                <!-- Floating Action Button effect -->
                <div class="absolute -top-6 right-8 w-12 h-12 bg-amber-600 text-white rounded-full flex items-center justify-center shadow-lg transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                  <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </div>

                <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-amber-600 transition-colors"><?php the_title(); ?></h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-2"><?php echo get_the_excerpt(); ?></p>
                <div class="flex items-center gap-4 text-xs text-slate-400 font-medium uppercase tracking-wider border-t border-slate-100 pt-4">
                  <span><?php echo $location; ?></span>
                  <span class="w-1 h-1 bg-amber-500 rounded-full"></span>
                  <span><?php echo $date; ?></span>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filters = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.gallery-item');

    filters.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            filters.forEach(b => {
                b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg', 'scale-105');
                b.classList.add('bg-white', 'text-slate-500', 'hover:bg-slate-200', 'border', 'border-slate-100');
            });
            btn.classList.remove('bg-white', 'text-slate-500', 'hover:bg-slate-200', 'border', 'border-slate-100');
            btn.classList.add('bg-slate-900', 'text-white', 'shadow-lg', 'scale-105');

            const filterValue = btn.getAttribute('data-filter');

            items.forEach(item => {
                if (filterValue === 'all' || item.getAttribute('data-category').includes(filterValue)) {
                    item.style.display = 'block';
                    // Add animation class if needed
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
